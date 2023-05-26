admin feature --- todo

login
    validate inputs
    match password
register
    validate inputs
    check if username or email exist
    hash password

get user/profile
get list of users/profiles

friends extends user
add
remove

# use error page for errors

// protocol = http://
// subDomain = www.
// domainName = example.com
// port = :#
// path = /[folder]/[file]
// paramerters = ?key=value
// fragment = #somefragments

(\?\w+).+(\&\w+)

(\?\w+).+(\&\w+)


/login
	validate
		is user exist
		is password correct

/register
	validate
		is user doesn't exist
		is email, user valid
		is password valid
		is password match

/
	is logged in / check for auth

/?username
	is logged in / check for auth
	
/?username/message/channel_id
	is logged in
	is user connected/friend with another user