#!/bin/bash

echo "=== Testing Student Profile Major Filtering ==="
echo

echo "1. All Majors (should return 8 profiles):"
curl -s "http://localhost:8000/api/v1/student-profiles" | jq '.data | length'
echo

echo "2. Computer Science (should return 2 profiles):"
curl -s "http://localhost:8000/api/v1/student-profiles?major=Computer%20Science" | jq '.data | length'
curl -s "http://localhost:8000/api/v1/student-profiles?major=Computer%20Science" | jq -r '.data[].name'
echo

echo "3. Business Administration (should return 1 profile):"
curl -s "http://localhost:8000/api/v1/student-profiles?major=Business%20Administration" | jq '.data | length'
curl -s "http://localhost:8000/api/v1/student-profiles?major=Business%20Administration" | jq -r '.data[].name'
echo

echo "4. Engineering (should return 1 profile):"
curl -s "http://localhost:8000/api/v1/student-profiles?major=Engineering" | jq '.data | length'
curl -s "http://localhost:8000/api/v1/student-profiles?major=Engineering" | jq -r '.data[].name'
echo

echo "5. Psychology (should return 2 profiles):"
curl -s "http://localhost:8000/api/v1/student-profiles?major=Psychology" | jq '.data | length'
curl -s "http://localhost:8000/api/v1/student-profiles?major=Psychology" | jq -r '.data[].name'
echo

echo "6. Biology (should return 1 profile):"
curl -s "http://localhost:8000/api/v1/student-profiles?major=Biology" | jq '.data | length'
curl -s "http://localhost:8000/api/v1/student-profiles?major=Biology" | jq -r '.data[].name'
echo

echo "7. Art & Design (should return 1 profile):"
curl -s "http://localhost:8000/api/v1/student-profiles?major=Art%20%26%20Design" | jq '.data | length'
curl -s "http://localhost:8000/api/v1/student-profiles?major=Art%20%26%20Design" | jq -r '.data[].name'
echo

echo "=== All major filtering buttons should now work correctly! ==="