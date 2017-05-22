# Backend User Wrapper
Pimcore plugin that wraps Objects around Pimcore User Model.
# Features
  - Create an User object to create regular Pimcore User
  - Use workspaces and custom views to fine-tune permissions for creating and managing users
# Installation
```
composer require divante-ltd/backend-user-wrapper
```
After installation, go to Extensions in your Pimcore admin panel, click on configure. Choose your User class name and save. Click Enable, then Install and you should be ready to go.
# TODO
  - Add support for all of the permissions from User Model
  - Send an e-mail with instructions to reset password after User creation
