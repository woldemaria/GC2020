#!/bin/bash

# Create directories
mkdir -p public/images/departments
mkdir -p public/images/graduation

# Create department images using SVG
cat > public/images/departments/computer-science.jpg << 'EOF'
<svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#3B82F6;stop-opacity:1" />
      <stop offset="100%" style="stop-color:#1E40AF;stop-opacity:1" />
    </linearGradient>
  </defs>
  <rect width="400" height="300" fill="url(#grad1)"/>
  <circle cx="100" cy="80" r="30" fill="rgba(255,255,255,0.2)"/>
  <circle cx="320" cy="220" r="40" fill="rgba(255,255,255,0.1)"/>
  <rect x="50" y="120" width="80" height="50" rx="5" fill="rgba(255,255,255,0.3)"/>
  <rect x="270" y="60" width="80" height="50" rx="5" fill="rgba(255,255,255,0.3)"/>
  <text x="200" y="160" text-anchor="middle" fill="white" font-family="Arial" font-size="24" font-weight="bold">Computer Science</text>
  <text x="200" y="185" text-anchor="middle" fill="rgba(255,255,255,0.8)" font-family="Arial" font-size="14">& Information Technology</text>
</svg>
EOF

cat > public/images/departments/engineering.jpg << 'EOF'
<svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="grad2" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#DC2626;stop-opacity:1" />
      <stop offset="100%" style="stop-color:#991B1B;stop-opacity:1" />
    </linearGradient>
  </defs>
  <rect width="400" height="300" fill="url(#grad2)"/>
  <polygon points="80,80 120,60 160,80 160,120 80,120" fill="rgba(255,255,255,0.3)"/>
  <polygon points="240,180 280,160 320,180 320,220 240,220" fill="rgba(255,255,255,0.2)"/>
  <circle cx="320" cy="80" r="25" fill="rgba(255,255,255,0.2)"/>
  <text x="200" y="160" text-anchor="middle" fill="white" font-family="Arial" font-size="24" font-weight="bold">Engineering</text>
  <text x="200" y="185" text-anchor="middle" fill="rgba(255,255,255,0.8)" font-family="Arial" font-size="14">Innovation & Design</text>
</svg>
EOF

cat > public/images/departments/business.jpg << 'EOF'
<svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="grad3" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#059669;stop-opacity:1" />
      <stop offset="100%" style="stop-color:#064E3B;stop-opacity:1" />
    </linearGradient>
  </defs>
  <rect width="400" height="300" fill="url(#grad3)"/>
  <rect x="60" y="60" width="100" height="60" rx="5" fill="rgba(255,255,255,0.2)"/>
  <rect x="240" y="180" width="100" height="60" rx="5" fill="rgba(255,255,255,0.3)"/>
  <circle cx="320" cy="100" r="20" fill="rgba(255,255,255,0.2)"/>
  <text x="200" y="160" text-anchor="middle" fill="white" font-family="Arial" font-size="24" font-weight="bold">Business</text>
  <text x="200" y="185" text-anchor="middle" fill="rgba(255,255,255,0.8)" font-family="Arial" font-size="14">& Management</text>
</svg>
EOF

cat > public/images/departments/medicine.jpg << 'EOF'
<svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="grad4" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#EF4444;stop-opacity:1" />
      <stop offset="100%" style="stop-color:#B91C1C;stop-opacity:1" />
    </linearGradient>
  </defs>
  <rect width="400" height="300" fill="url(#grad4)"/>
  <rect x="180" y="80" width="10" height="40" fill="white"/>
  <rect x="165" y="95" width="40" height="10" fill="white"/>
  <circle cx="100" cy="200" r="30" fill="rgba(255,255,255,0.2)"/>
  <circle cx="320" cy="80" r="25" fill="rgba(255,255,255,0.1)"/>
  <text x="200" y="160" text-anchor="middle" fill="white" font-family="Arial" font-size="24" font-weight="bold">Medicine</text>
  <text x="200" y="185" text-anchor="middle" fill="rgba(255,255,255,0.8)" font-family="Arial" font-size="14">& Health Sciences</text>
</svg>
EOF

cat > public/images/departments/sciences.jpg << 'EOF'
<svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="grad5" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#D97706;stop-opacity:1" />
      <stop offset="100%" style="stop-color:#92400E;stop-opacity:1" />
    </linearGradient>
  </defs>
  <rect width="400" height="300" fill="url(#grad5)"/>
  <circle cx="120" cy="100" r="25" fill="rgba(255,255,255,0.3)"/>
  <circle cx="280" cy="180" r="30" fill="rgba(255,255,255,0.2)"/>
  <rect x="300" y="70" width="40" height="40" rx="20" fill="rgba(255,255,255,0.2)"/>
  <text x="200" y="160" text-anchor="middle" fill="white" font-family="Arial" font-size="24" font-weight="bold">Natural Sciences</text>
  <text x="200" y="185" text-anchor="middle" fill="rgba(255,255,255,0.8)" font-family="Arial" font-size="14">Research & Discovery</text>
</svg>
EOF

cat > public/images/departments/social-sciences.jpg << 'EOF'
<svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="grad6" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#6366F1;stop-opacity:1" />
      <stop offset="100%" style="stop-color:#4338CA;stop-opacity:1" />
    </linearGradient>
  </defs>
  <rect width="400" height="300" fill="url(#grad6)"/>
  <circle cx="80" cy="80" r="20" fill="rgba(255,255,255,0.3)"/>
  <circle cx="120" cy="120" r="15" fill="rgba(255,255,255,0.2)"/>
  <circle cx="300" cy="200" r="25" fill="rgba(255,255,255,0.2)"/>
  <text x="200" y="160" text-anchor="middle" fill="white" font-family="Arial" font-size="24" font-weight="bold">Social Sciences</text>
  <text x="200" y="185" text-anchor="middle" fill="rgba(255,255,255,0.8)" font-family="Arial" font-size="14">Human Behavior & Society</text>
</svg>
EOF

# Create graduation ceremony images
for i in {1..6}; do
cat > public/images/graduation/ceremony-$i.jpg << EOF
<svg width="400" height="400" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="gradGrad$i" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#1E40AF;stop-opacity:1" />
      <stop offset="100%" style="stop-color:#3B82F6;stop-opacity:1" />
    </linearGradient>
  </defs>
  <rect width="400" height="400" fill="url(#gradGrad$i)"/>
  <polygon points="200,80 160,120 240,120" fill="#FCD34D"/>
  <rect x="195" y="120" width="10" height="30" fill="#92400E"/>
  <circle cx="200" cy="160" r="40" fill="rgba(255,255,255,0.9)"/>
  <text x="200" y="240" text-anchor="middle" fill="white" font-family="Arial" font-size="18" font-weight="bold">Graduation $i</text>
  <text x="200" y="260" text-anchor="middle" fill="rgba(255,255,255,0.8)" font-family="Arial" font-size="12">Class of 2024</text>
  <rect x="50" y="300" width="60" height="40" rx="5" fill="rgba(255,255,255,0.2)"/>
  <rect x="290" y="320" width="60" height="40" rx="5" fill="rgba(255,255,255,0.2)"/>
</svg>
EOF
done

echo "University images created successfully!"