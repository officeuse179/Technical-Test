---------------- REGISTER API-----------------

API Call URL: http://127.0.0.1:8000/api/register
Method: POST

BODY RAW JSON

{
"first_name":"Raja",
"last_name":"Jalil",
"email":"test@test.com",
"password":"test123",
"confirmpassword":"test123",
"address":"address",
"dob":"04/7/2023",
"interests[]":[1,3]
}

---------------- LOGIN API-----------------

API Call URL: http://127.0.0.1:8000/api/register
Method: POST

BODY RAW JSON

{
"email":"test223@test.com",
"password":"test123"
}

---------------- PORFILE API-----------------

API Call URL: http://127.0.0.1:8000/api/userprofile/{ID} -> 1,2 etc
Method: GET

SET VARIABLE IN HEADER
KEY => Authorization
VALUE => Bearer {PASS LOGIN TOKEN} -> like --> Bearer 17|0CasYKB2dErxPmu3gu0N5FVGm5ZHnifLrTu32GYM

If get any issues to call APIs kindly see the video. the video has been attached to the email.