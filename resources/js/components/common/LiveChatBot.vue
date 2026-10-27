<template>
    <!-- Chat Toggle Button -->
    <div class="fixed bottom-6 right-6 z-[9999]">
        <!-- Notification Badge -->
        <div
            v-if="unreadCount > 0 && !isOpen"
            class="absolute -top-2 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center animate-bounce"
        >
            {{ unreadCount }}
        </div>

        <!-- Chat Button -->
        <button
            @click="toggleChat"
            class="group relative w-14 h-14 rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:scale-110"
            :class="isOpen ? 'bg-gray-700 hover:bg-gray-800' : 'bg-blue-600 hover:bg-blue-700'"
        >
            <!-- Chat icon -->
            <svg v-if="!isOpen" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <!-- Close icon -->
            <svg v-else class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>

            <!-- Pulse ring when closed -->
            <span v-if="!isOpen" class="absolute inset-0 rounded-full bg-blue-600 animate-ping opacity-20"></span>
        </button>

        <!-- Chat Window -->
        <transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="opacity-0 scale-90 translate-y-4"
            enter-to-class="opacity-100 scale-100 translate-y-0"
            leave-active-class="transition-all duration-200 ease-in"
            leave-from-class="opacity-100 scale-100 translate-y-0"
            leave-to-class="opacity-0 scale-90 translate-y-4"
        >
            <div
                v-if="isOpen"
                class="absolute bottom-16 right-0 w-[360px] max-w-[calc(100vw-2rem)] bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden flex flex-col"
                style="height: 520px"
            >
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-3 flex items-center justify-between flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
                            <span class="text-lg">🤖</span>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-sm">GC Assistant</h3>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                                <span class="text-blue-100 text-xs">Online now</span>
                            </div>
                        </div>
                    </div>
                    <button @click="clearChat" class="text-white/70 hover:text-white transition p-1" title="Clear chat">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>

                <!-- Messages -->
                <div ref="messagesContainer" class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50">
                    <div v-for="(msg, idx) in messages" :key="idx"
                        :class="['flex', msg.sender === 'user' ? 'justify-end' : 'justify-start']"
                    >
                        <!-- Bot avatar -->
                        <div v-if="msg.sender === 'bot'" class="flex-shrink-0 mr-2">
                            <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center text-sm">
                                🤖
                            </div>
                        </div>

                        <div
                            :class="[
                                'max-w-[80%] px-4 py-2.5 rounded-2xl text-sm leading-relaxed',
                                msg.sender === 'user'
                                    ? 'bg-blue-600 text-white rounded-br-md'
                                    : 'bg-white text-gray-800 shadow-sm border border-gray-100 rounded-bl-md'
                            ]"
                        >
                            <div v-html="formatMessage(msg.text)"></div>
                            <div :class="['text-[10px] mt-1', msg.sender === 'user' ? 'text-blue-200' : 'text-gray-400']">
                                {{ msg.time }}
                            </div>
                        </div>
                    </div>

                    <!-- Typing indicator -->
                    <div v-if="isTyping" class="flex justify-start">
                        <div class="flex-shrink-0 mr-2">
                            <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center text-sm">
                                🤖
                            </div>
                        </div>
                        <div class="bg-white px-4 py-3 rounded-2xl rounded-bl-md shadow-sm border border-gray-100">
                            <div class="flex gap-1">
                                <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                                <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                                <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Replies -->
                <div v-if="quickReplies.length > 0 && !isTyping" class="px-4 py-2 flex flex-wrap gap-1.5 bg-gray-50 border-t border-gray-100 flex-shrink-0">
                    <button
                        v-for="(reply, idx) in quickReplies"
                        :key="idx"
                        @click="sendQuickReply(reply)"
                        class="px-3 py-1.5 bg-white border border-blue-200 text-blue-700 rounded-full text-xs font-medium hover:bg-blue-50 hover:border-blue-300 transition-colors"
                    >
                        {{ reply }}
                    </button>
                </div>

                <!-- Input -->
                <div class="border-t border-gray-200 p-3 bg-white flex-shrink-0">
                    <form @submit.prevent="sendMessage" class="flex items-center gap-2">
                        <input
                            ref="chatInput"
                            v-model="userInput"
                            type="text"
                            placeholder="Type your message..."
                            class="flex-1 px-4 py-2.5 bg-gray-100 border-0 rounded-full text-sm focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors outline-none"
                            :disabled="isTyping"
                        />
                        <button
                            type="submit"
                            :disabled="!userInput.trim() || isTyping"
                            class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors flex-shrink-0"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    name: "LiveChatBot",
    data() {
        return {
            isOpen: false,
            isTyping: false,
            userInput: "",
            unreadCount: 1,
            messages: [],
            quickReplies: [],
            knowledgeBase: {
                greetings: [
                    "Hello! 👋 Welcome to GC University! I'm your virtual assistant. How can I help you today?",
                    "Hi there! 😊 I'm the GC University chatbot. Feel free to ask me anything about our programs, campus, or services!",
                ],
                admissions: {
                    response: "📋 **Admissions Information:**\n\nOur admissions process includes:\n• **Undergraduate:** Applications open Sept-Dec each year\n• **Postgraduate:** Rolling admissions available\n• **Required documents:** Transcripts, ID, passport photos\n• **Application fee:** 500 ETB\n\nYou can start your application at the **Apply** page or contact admissions at **admissions@gcuniversity.edu.et**",
                    quickReplies: ["Application deadlines", "Required documents", "Tuition fees", "Back to menu"],
                },
                programs: {
                    response: "🎓 **Our Academic Programs:**\n\n**Undergraduate:**\n• Computer Science\n• Business Administration\n• Engineering (Civil, Electrical, Mechanical)\n• Health Sciences\n• Law\n• Social Sciences\n\n**Postgraduate:**\n• MBA\n• MSc in Computer Science\n• MA in Development Studies\n• PhD programs available\n\nVisit the **Departments** page for full details!",
                    quickReplies: ["Admissions info", "Tuition fees", "Campus facilities", "Back to menu"],
                },
                fees: {
                    response: "💰 **Tuition & Fees:**\n\n• **Undergraduate:** 8,000 - 15,000 ETB/semester\n• **Postgraduate:** 12,000 - 25,000 ETB/semester\n• **Registration fee:** 500 ETB (one-time)\n• **Library fee:** 200 ETB/semester\n\n**Scholarships available!** Merit-based and need-based financial aid. Contact the finance office for details.",
                    quickReplies: ["Scholarships", "Payment methods", "Admissions info", "Back to menu"],
                },
                campus: {
                    response: "🏫 **Campus Facilities:**\n\n• 📚 JFK Memorial Library with 50,000+ volumes\n• 💻 Modern ICT Center & Computer Labs\n• 🏟️ Sports Complex (stadium, gym, pool)\n• 🍽️ Student Cafeteria\n• 🏥 University Health Center\n• 🏠 Student Dormitories\n• 🅿️ Parking facilities\n\nExplore our campus on the **Campus Map** page!",
                    quickReplies: ["Campus map", "Library hours", "Sports facilities", "Back to menu"],
                },
                contact: {
                    response: "📞 **Contact Information:**\n\n• **Phone:** +251-11-123-4567\n• **Email:** info@gcuniversity.edu.et\n• **Admissions:** admissions@gcuniversity.edu.et\n• **Address:** GC University Campus, Addis Ababa, Ethiopia\n\n**Office Hours:**\nMon-Fri: 8:00 AM - 5:00 PM\nSaturday: 9:00 AM - 2:00 PM",
                    quickReplies: ["Campus map", "Admissions info", "Programs", "Back to menu"],
                },
                certificates: {
                    response: "📜 **Certificate Services:**\n\n• **Verification:** Use our online **Certificate Verification** page\n• **Transcripts:** Request via the Student Services Center\n• **Processing time:** 3-5 business days\n• **Fee:** 200 ETB per copy\n\nFor urgent requests, contact the registrar at **registrar@gcuniversity.edu.et**",
                    quickReplies: ["Verify certificate", "Contact registrar", "Back to menu"],
                },
                graduation: {
                    response: "🎓 **Graduation Information:**\n\n• **Ceremony:** Held annually in July\n• **Gown & Cap:** Available for order on our website\n• **Photos:** Professional photography available\n• **Requirements:** Complete all courses + clear financial obligations\n\nVisit the **Graduation Gallery** to see past ceremonies!",
                    quickReplies: ["Order gown & cap", "View gallery", "Back to menu"],
                },
                library: {
                    response: "📚 **Library Hours:**\n\n• **Mon-Fri:** 7:00 AM - 9:00 PM\n• **Saturday:** 8:00 AM - 6:00 PM\n• **Sunday:** 10:00 AM - 4:00 PM\n\n**Services:** Book borrowing, e-resources, study rooms, printing, Wi-Fi access.\n\nLibrary card required — get yours at the front desk with your student ID.",
                    quickReplies: ["Campus facilities", "Contact", "Back to menu"],
                },
                defaultResponse: {
                    response: "I'm not sure I understand that question. Let me help you with some common topics! 😊",
                    quickReplies: ["Admissions", "Programs", "Tuition fees", "Campus info", "Contact us", "Certificates"],
                },
            },
        };
    },
    methods: {
        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.unreadCount = 0;
                if (this.messages.length === 0) {
                    this.addBotMessage(
                        this.knowledgeBase.greetings[Math.floor(Math.random() * this.knowledgeBase.greetings.length)]
                    );
                    this.quickReplies = ["Admissions", "Programs", "Tuition fees", "Campus info", "Contact us", "Certificates"];
                }
                this.$nextTick(() => {
                    this.$refs.chatInput?.focus();
                });
            }
        },

        sendMessage() {
            const text = this.userInput.trim();
            if (!text) return;

            this.addUserMessage(text);
            this.userInput = "";
            this.quickReplies = [];
            this.processMessage(text);
        },

        sendQuickReply(reply) {
            this.addUserMessage(reply);
            this.quickReplies = [];
            this.processMessage(reply);
        },

        processMessage(text) {
            this.isTyping = true;
            this.scrollToBottom();

            const delay = 600 + Math.random() * 800;

            setTimeout(() => {
                const { response, replies } = this.getResponse(text.toLowerCase());
                this.isTyping = false;
                this.addBotMessage(response);
                this.quickReplies = replies;

                if (!this.isOpen) {
                    this.unreadCount++;
                }
            }, delay);
        },

        getResponse(text) {
            const kb = this.knowledgeBase;

            // Greetings
            if (/^(hi|hello|hey|good\s*(morning|afternoon|evening)|greetings|selam|salam)/i.test(text)) {
                return {
                    response: kb.greetings[Math.floor(Math.random() * kb.greetings.length)],
                    replies: ["Admissions", "Programs", "Tuition fees", "Campus info", "Contact us"],
                };
            }

            // Admissions
            if (/admiss|apply|application|enroll|register|signup|join/i.test(text)) {
                return { response: kb.admissions.response, replies: kb.admissions.quickReplies };
            }

            // Programs
            if (/program|course|department|degree|major|study|undergrad|postgrad|master|phd|bachelor/i.test(text)) {
                return { response: kb.programs.response, replies: kb.programs.quickReplies };
            }

            // Fees
            if (/fee|tuition|cost|price|payment|pay|scholar|financial|money/i.test(text)) {
                return { response: kb.fees.response, replies: kb.fees.quickReplies };
            }

            // Campus
            if (/campus|facilit|building|map|location|where|direction|dorm|housing/i.test(text)) {
                return { response: kb.campus.response, replies: kb.campus.quickReplies };
            }

            // Contact
            if (/contact|phone|email|address|reach|call|office/i.test(text)) {
                return { response: kb.contact.response, replies: kb.contact.quickReplies };
            }

            // Certificates
            if (/certif|transcript|verif|document|diploma/i.test(text)) {
                return { response: kb.certificates.response, replies: kb.certificates.quickReplies };
            }

            // Graduation
            if (/graduat|ceremony|gown|cap|commencement/i.test(text)) {
                return { response: kb.graduation.response, replies: kb.graduation.quickReplies };
            }

            // Library
            if (/library|book|reading|study\s*room/i.test(text)) {
                return { response: kb.library.response, replies: kb.library.quickReplies };
            }

            // Deadline
            if (/deadline|when|date|schedule|calendar/i.test(text)) {
                return {
                    response: "📅 **Important Dates:**\n\n• **Application deadline:** December 30, 2026\n• **Semester start:** February 2027\n• **Exam period:** June 2027\n• **Graduation ceremony:** July 2027\n\nCheck the **News & Events** page for the latest updates!",
                    replies: ["Admissions info", "Contact us", "Back to menu"],
                };
            }

            // Thanks
            if (/thank|thanks|appreciate/i.test(text)) {
                return {
                    response: "You're welcome! 😊 I'm always here to help. Is there anything else you'd like to know?",
                    replies: ["Admissions", "Programs", "Contact us", "Back to menu"],
                };
            }

            // Back to menu
            if (/back.*menu|menu|help|start over|main/i.test(text)) {
                return {
                    response: "Sure! Here are the topics I can help with: 👇",
                    replies: ["Admissions", "Programs", "Tuition fees", "Campus info", "Contact us", "Certificates"],
                };
            }

            // Default
            return { response: kb.defaultResponse.response, replies: kb.defaultResponse.quickReplies };
        },

        addUserMessage(text) {
            this.messages.push({
                sender: "user",
                text: text,
                time: this.getTime(),
            });
            this.scrollToBottom();
        },

        addBotMessage(text) {
            this.messages.push({
                sender: "bot",
                text: text,
                time: this.getTime(),
            });
            this.scrollToBottom();
        },

        formatMessage(text) {
            // Convert markdown-like formatting to HTML
            return text
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\n/g, '<br>')
                .replace(/• /g, '&bull; ');
        },

        getTime() {
            return new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.messagesContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            });
        },

        clearChat() {
            this.messages = [];
            this.quickReplies = [];
            this.addBotMessage(
                this.knowledgeBase.greetings[Math.floor(Math.random() * this.knowledgeBase.greetings.length)]
            );
            this.quickReplies = ["Admissions", "Programs", "Tuition fees", "Campus info", "Contact us", "Certificates"];
        },
    },
};
</script>
