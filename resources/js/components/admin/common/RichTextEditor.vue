<template>
  <div class="rich-text-editor">
    <div ref="editorRef" class="border border-gray-300 rounded-md min-h-[300px]"></div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  },
  placeholder: {
    type: String,
    default: 'Start writing...'
  },
  height: {
    type: String,
    default: '300px'
  }
});

const emit = defineEmits(['update:modelValue', 'change']);

const editorRef = ref(null);
let editorInstance = null;

const initializeEditor = () => {
  // Simple rich text editor using contenteditable
  const editor = editorRef.value;
  editor.contentEditable = true;
  editor.style.minHeight = props.height;
  editor.style.padding = '12px';
  editor.style.outline = 'none';
  editor.innerHTML = props.modelValue || '';

  // Add toolbar
  const toolbar = document.createElement('div');
  toolbar.className = 'flex items-center space-x-2 p-2 bg-gray-50 border-b border-gray-300 rounded-t-md';
  toolbar.innerHTML = `
    <button type="button" class="toolbar-btn" data-command="bold" title="Bold">
      <strong>B</strong>
    </button>
    <button type="button" class="toolbar-btn" data-command="italic" title="Italic">
      <em>I</em>
    </button>
    <button type="button" class="toolbar-btn" data-command="underline" title="Underline">
      <u>U</u>
    </button>
    <div class="border-l border-gray-300 h-6 mx-2"></div>
    <button type="button" class="toolbar-btn" data-command="formatBlock" data-value="h1" title="Heading 1">
      H1
    </button>
    <button type="button" class="toolbar-btn" data-command="formatBlock" data-value="h2" title="Heading 2">
      H2
    </button>
    <button type="button" class="toolbar-btn" data-command="formatBlock" data-value="h3" title="Heading 3">
      H3
    </button>
    <button type="button" class="toolbar-btn" data-command="formatBlock" data-value="p" title="Paragraph">
      P
    </button>
    <div class="border-l border-gray-300 h-6 mx-2"></div>
    <button type="button" class="toolbar-btn" data-command="insertUnorderedList" title="Bullet List">
      • List
    </button>
    <button type="button" class="toolbar-btn" data-command="insertOrderedList" title="Numbered List">
      1. List
    </button>
    <div class="border-l border-gray-300 h-6 mx-2"></div>
    <button type="button" class="toolbar-btn" data-command="createLink" title="Insert Link">
      Link
    </button>
    <button type="button" class="toolbar-btn image-btn" title="Insert Image">
      Image
    </button>
  `;

  // Add toolbar styles
  const style = document.createElement('style');
  style.textContent = `
    .toolbar-btn {
      padding: 4px 8px;
      border: 1px solid #d1d5db;
      background: white;
      border-radius: 4px;
      font-size: 12px;
      cursor: pointer;
      transition: all 0.15s ease;
    }
    .toolbar-btn:hover {
      background: #f3f4f6;
      border-color: #9ca3af;
    }
    .toolbar-btn:active {
      background: rgba(229, 231, 235, 1);
    }
  `;
  document.head.appendChild(style);

  // Insert toolbar before editor
  editor.parentNode.insertBefore(toolbar, editor);

  // Toolbar event handlers
  toolbar.addEventListener('click', (e) => {
    e.preventDefault();
    const button = e.target.closest('.toolbar-btn');
    if (!button) return;

    const command = button.dataset.command;
    const value = button.dataset.value;

    if (command === 'createLink') {
      const url = prompt('Enter URL:');
      if (url) {
        document.execCommand(command, false, url);
      }
    } else if (button.classList.contains('image-btn')) {
      handleImageInsert();
    } else {
      document.execCommand(command, false, value);
    }
    
    editor.focus();
    handleInput();
  });

  // Editor event handlers
  editor.addEventListener('input', handleInput);
  editor.addEventListener('paste', handlePaste);

  // Set placeholder
  if (!editor.innerHTML.trim()) {
    editor.innerHTML = `<p style="color: #9ca3af;">${props.placeholder}</p>`;
  }

  editor.addEventListener('focus', () => {
    if (editor.innerHTML.includes(props.placeholder)) {
      editor.innerHTML = '';
    }
  });

  editor.addEventListener('blur', () => {
    if (!editor.innerHTML.trim()) {
      editor.innerHTML = `<p style="color: #9ca3af;">${props.placeholder}</p>`;
    }
  });

  editorInstance = editor;
};

const handleInput = () => {
  const content = editorInstance.innerHTML;
  if (!content.includes(props.placeholder)) {
    emit('update:modelValue', content);
    emit('change', content);
  }
};

const handlePaste = (e) => {
  e.preventDefault();
  const text = e.clipboardData.getData('text/plain');
  document.execCommand('insertHTML', false, text);
  handleInput();
};

const handleImageInsert = () => {
  // Create file input
  const input = document.createElement('input');
  input.type = 'file';
  input.accept = 'image/*';
  
  input.addEventListener('change', async (e) => {
    const file = e.target.files[0];
    if (!file) return;

    // Show loading indicator
    const loadingMsg = document.createElement('span');
    loadingMsg.textContent = 'Uploading image...';
    loadingMsg.style.color = '#3b82f6';
    loadingMsg.style.fontStyle = 'italic';
    document.execCommand('insertHTML', false, loadingMsg.outerHTML);

    try {
      // Validate file size (10MB limit)
      if (file.size > 10 * 1024 * 1024) {
        throw new Error('File size must be less than 10MB');
      }

      // Validate file type
      if (!file.type.startsWith('image/')) {
        throw new Error('Please select an image file');
      }

      // Create FormData for upload
      const formData = new FormData();
      formData.append('image', file);
      formData.append('type', 'article');

      // Upload image
      const response = await fetch('/api/admin/media/upload', {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
        }
      });

      const result = await response.json();
      
      // Remove loading message
      const loadingElement = editorInstance.querySelector('span');
      if (loadingElement && loadingElement.textContent === 'Uploading image...') {
        loadingElement.remove();
      }
      
      if (result.success) {
        // Insert image into editor
        const img = `<img src="${result.data.path}" alt="${file.name}" style="max-width: 100%; height: auto; margin: 10px 0; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">`;
        document.execCommand('insertHTML', false, img);
        handleInput();
      } else {
        // Show error message
        const errorMsg = `<span style="color: #ef4444; font-style: italic;">Failed to upload image: ${result.message}</span>`;
        document.execCommand('insertHTML', false, errorMsg);
      }
    } catch (error) {
      // Remove loading message if exists
      const loadingElement = editorInstance.querySelector('span');
      if (loadingElement && loadingElement.textContent === 'Uploading image...') {
        loadingElement.remove();
      }
      
      // Show error message
      const errorMsg = `<span style="color: #ef4444; font-style: italic;">Error: ${error.message}</span>`;
      document.execCommand('insertHTML', false, errorMsg);
    }
  });
  
  input.click();
};

// Watch for external changes
watch(() => props.modelValue, (newValue) => {
  if (editorInstance && editorInstance.innerHTML !== newValue) {
    editorInstance.innerHTML = newValue || '';
  }
});

onMounted(() => {
  initializeEditor();
});

onUnmounted(() => {
  if (editorInstance) {
    editorInstance.removeEventListener('input', handleInput);
    editorInstance.removeEventListener('paste', handlePaste);
  }
});
</script>

<style scoped>
.rich-text-editor :deep(h1) {
  font-size: 1.875rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
}

.rich-text-editor :deep(h2) {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.rich-text-editor :deep(h3) {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.rich-text-editor :deep(p) {
  margin-bottom: 0.75rem;
}

.rich-text-editor :deep(ul),
.rich-text-editor :deep(ol) {
  margin-bottom: 0.75rem;
  padding-left: 1.5rem;
}

.rich-text-editor :deep(li) {
  margin-bottom: 0.25rem;
}

.rich-text-editor :deep(a) {
  color: #2563eb;
  text-decoration: underline;
}

.rich-text-editor :deep(img) {
  max-width: 100%;
  height: auto;
  margin: 0.5rem 0;
}
</style>