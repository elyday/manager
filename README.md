![PHPUnit](https://github.com/elyday/manager/workflows/PHPUnit/badge.svg?branch=main)
[![codecov](https://codecov.io/gh/elyday/manager/branch/main/graph/badge.svg?token=KWQNU2QRPC)](https://codecov.io/gh/elyday/manager)

## About Manager

Manager is supposed to become a web application that can be used to manage a virtual fictitious company. It should contain the following functionalities at some point:

- Bank Account Management
- Staff Administration
- Customer Management

This web application is still under development and no stable release has been published yet.

### Technology Stack
This web application uses the following libraries and other stuff:

- [Laravel 8](https://laravel.com/)
    - Laravel Jetstream (includes Sanctum, Tinker and Livewire)
- [Tailwind CSS](https://tailwindcss.com/)

#### Laravel Jetstream
We use Laravel Jetstream because it covers all our requirements and we have to build as little as possible ourselves. All components within the application will depend on the teams, so resources can be shared within the teams.