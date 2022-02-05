![GitHub language count](https://img.shields.io/github/languages/count/niece1/making-social-example)
![GitHub top language](https://img.shields.io/github/languages/top/niece1/making-social-example)
![GitHub repo size](https://img.shields.io/github/repo-size/niece1/making-social-example)
![GitHub contributors](https://img.shields.io/github/contributors/niece1/making-social-example)
![GitHub last commit](https://img.shields.io/github/last-commit/niece1/making-social-example)
![GitHub](https://img.shields.io/github/license/niece1/making-social-example)

## Intro

This repo is an example of how to make social apps using Laravel.

## Usage

If it happens you decide to run it on your machine, follow the steps below.

Clone repository.

To generate APP_KEY run:
```
php artisan key:generate
```

To install dependencies run command:
```
composer install
```

In your **.env** file fill in the variables related to your database and add following Pusher environment variables:
```
- PUSHER_APP_ID=local
- PUSHER_APP_KEY=local
- PUSHER_APP_SECRET=local
- PUSHER_APP_CLUSTER=mt1
- MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
- MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

To perform database migrations run:
```
php artisan migrate
```

## Key features

First, you need to create account, login and proceed to the timeline page. As an authenticated user you can follow friends, can be added to someone's friend list, create posts, upload images and video files (including multiple upload), repost and like anyone's post in realtime, receive notifications etc.

## Technical features

```
- Vue/Vuex
- Api resources
- Events
- Laravel-websockets/Pusher
- Notifications
- Laravel Breeze authentication
- Spatie Media Library
```

## License

This is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
