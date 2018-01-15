# One-time Password Retrieval
This tool encrypts a password with a random private key.
When the password is retrieved, it is deleted and can no longer be retrieved.
The purpose is to share passwords while reducing the possibility of them leaking.

# Software used
* Windows 10 Home
* Apache 2.4.29 (Win64)
* PHP 7.2.1 x64

# TODO
* Research whether it is worthwhile to switch to libsodium
* Send an email instead of displaying an id and the private key
* Consider the feature to automatically delete the password after a certain period
* Implement error handling