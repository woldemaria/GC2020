#!/bin/bash

# GC Magazine Website Functionality Test Script
echo "🧪 Testing GC Magazine Website Functionality..."

BASE_URL="http://localhost:8000"

# Test main website endpoints
echo "🌐 Testing main website endpoints..."

# Test homepage
echo -n "   Homepage: "
if curl -s "$BASE_URL" | grep -q "GC Magazine"; then
    echo "✅ OK"
else
    echo "❌ FAILED"
fi

# Test API endpoints
echo -n "   Articles API: "
if curl -s "$BASE_URL/api/v1/articles" | grep -q "success"; then
    echo "✅ OK"
else
    echo "❌ FAILED"
fi

echo -n "   Categories API: "
if curl -s "$BASE_URL/api/v1/categories" | grep -q "data"; then
    echo "✅ OK"
else
    echo "❌ FAILED"
fi

echo -n "   Photos API: "
if curl -s "$BASE_URL/api/v1/photos" | grep -q "data"; then
    echo "✅ OK"
else
    echo "❌ FAILED"
fi

echo -n "   Student Profiles API: "
if curl -s "$BASE_URL/api/v1/student-profiles" | grep -q "data"; then
    echo "✅ OK"
else
    echo "❌ FAILED"
fi

# Test admin API endpoints
echo "🔧 Testing admin API endpoints..."

echo -n "   Dashboard Stats: "
if curl -s "$BASE_URL/api/admin/dashboard/stats" | grep -q "success"; then
    echo "✅ OK"
else
    echo "❌ FAILED"
fi

echo -n "   System Status: "
if curl -s "$BASE_URL/api/admin/system-status" | grep -q "database"; then
    echo "✅ OK"
else
    echo "❌ FAILED"
fi

echo -n "   Articles Management: "
if curl -s "$BASE_URL/api/admin/articles" | grep -q "data"; then
    echo "✅ OK"
else
    echo "❌ FAILED"
fi

echo -n "   Media List: "
if curl -s "$BASE_URL/api/admin/media/list" | grep -q "success"; then
    echo "✅ OK"
else
    echo "❌ FAILED"
fi

# Test file system
echo "📁 Testing file system..."

echo -n "   Storage symlink: "
if [ -L "public/storage" ]; then
    echo "✅ OK"
else
    echo "❌ FAILED"
fi

echo -n "   Upload directories: "
if [ -d "storage/app/public/images/articles" ] && [ -d "storage/app/public/images/avatars" ]; then
    echo "✅ OK"
else
    echo "❌ FAILED"
fi

echo -n "   Directory permissions: "
if [ -w "storage/app/public" ]; then
    echo "✅ OK"
else
    echo "❌ FAILED"
fi

# Test database
echo "🗄️ Testing database..."

echo -n "   Database connection: "
if php artisan migrate:status > /dev/null 2>&1; then
    echo "✅ OK"
else
    echo "❌ FAILED"
fi

echo -n "   Sample data: "
if php artisan tinker --execute="echo App\Models\Article::count();" 2>/dev/null | grep -q "[1-9]"; then
    echo "✅ OK"
else
    echo "❌ FAILED"
fi

# Test assets
echo "🎨 Testing assets..."

echo -n "   CSS compiled: "
if [ -f "public/build/manifest.json" ]; then
    echo "✅ OK"
else
    echo "❌ FAILED"
fi

echo -n "   Admin assets: "
if [ -f "public/build/assets/admin-*.js" ]; then
    echo "✅ OK ($(ls public/build/assets/admin-*.js | wc -l) files)"
else
    echo "❌ FAILED"
fi

echo ""
echo "🎉 Functionality test complete!"
echo ""
echo "📋 Quick access:"
echo "   Main site: $BASE_URL"
echo "   Admin:     $BASE_URL/admin"  
echo "   Login:     $BASE_URL/login"
echo "   Test page: $BASE_URL/admin/test"
echo ""