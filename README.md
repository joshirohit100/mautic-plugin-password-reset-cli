# mautic-plugin-password-reset-cli
A small plugin which helps to reset the password of the user from command
line.

## How to add this to project
In the mautic root composer.json file, add below entry under `repositories`
section -

````
"type": "git",
"url": "https://github.com/joshirohit100/mautic-plugin-password-reset-cli.git"
````
Then run the composer require command
```
composer require joshirohit100/mautic-plugin-password-reset-cli
```

## Command
Provides a new command `mautic:reset:password` for password reset.
