#!/bin/bash

echo "=== COMPREHENSIVE SYSTEM CHECK ==="
echo

echo "1. Server Status:"
if curl -s "http://localhost:8000/" | grep -q "<!DOCTYPE html"; then
    echo "   ✅ Laravel server running on port 8000"
else
    echo "   ❌ Laravel server not responding"
fi

if curl -s "http://127.0.0.1:5173/" | grep -q "vite"; then
    echo "   ✅ Vite dev server running on port 5173"
else
    echo "   ⚠️  Vite dev server check inconclusive"
fi

echo

echo "2. API Endpoints:"
endpoints=(
    "api/v1/articles"
    "api/v1/categories" 
    "api/v1/photos"
    "api/v1/student-profiles"
    "api/v1/student-profiles/featured"
)

for endpoint in "${endpoints[@]}"; do
    if curl -s "http://localhost:8000/$endpoint" | jq . > /dev/null 2>&1; then
        echo "   ✅ $endpoint"
    else
        echo "   ❌ $endpoint"
    fi
done

echo

echo "3. Major Filtering Tests:"
majors=(
    ""
    "Computer%20Science"
    "Business%20Administration"
    "Engineering"
    "Psychology"
    "Biology"
    "Art%20%26%20Design"
)

for major in "${majors[@]}"; do
    url="http://localhost:8000/api/v1/student-profiles"
    if [ -n "$major" ]; then
        url="${url}?major=${major}"
        major_name=$(echo "$major" | sed 's/%20/ /g' | sed 's/%26/\&/g')
    else
        major_name="All Majors"
    fi
    
    count=$(curl -s "$url" | jq '.data | length' 2>/dev/null)
    if [ "$count" != "null" ] && [ "$count" -gt 0 ]; then
        echo "   ✅ $major_name: $count profiles"
    else
        echo "   ❌ $major_name: Error"
    fi
done

echo

echo "4. Key Image Assets:"
images=(
    "images/default-avatar.jpg"
    "images/avatars/sarah-martinez.jpg"
    "images/articles/graduation-2024.jpg"
    "images/gallery/science-lab.jpg"
)

for image in "${images[@]}"; do
    if curl -I "http://localhost:8000/$image" 2>/dev/null | grep -q "200 OK"; then
        echo "   ✅ $image"
    else
        echo "   ❌ $image"
    fi
done

echo

echo "5. Database Tables:"
tables=(
    "student_profiles:StudentProfile"
    "articles:Article"
    "categories:Category"
    "photos:Photo"
    "authors:Author"
    "users:User"
)

for table_info in "${tables[@]}"; do
    table=$(echo $table_info | cut -d: -f1)
    model=$(echo $table_info | cut -d: -f2)
    count=$(php artisan tinker --execute="echo App\\Models\\$model::count();" 2>/dev/null | tail -1)
    if [ "$count" -gt 0 ] 2>/dev/null; then
        echo "   ✅ $table: $count records"
    else
        echo "   ❌ $table: Error or empty"
    fi
done

echo

echo "6. Frontend Routes:"
routes=(
    ""
    "students"
    "articles"
    "gallery"
    "about"
    "contact"
    "admin"
)

for route in "${routes[@]}"; do
    url="http://localhost:8000/$route"
    if curl -s "$url" | grep -q "<!DOCTYPE html"; then
        echo "   ✅ /$route"
    else
        echo "   ❌ /$route"
    fi
done

echo

echo "=== CHECK COMPLETE ==="