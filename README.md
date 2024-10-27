# Laracheck

<center>
<img src="https://raw.githubusercontent.com/misterdevit/laracheck/refs/heads/main/_art/dashboard.png" style="width:100%;">
</center>

#### Introduction

Track Application errors and outages before your Users discover them! Laracheck is a simple-to-use Laravel error tracker and application uptime monitoring service.

#### Screenshots

<center>
<img src="https://raw.githubusercontent.com/misterdevit/laracheck/refs/heads/main/_art/errors.png" style="width:100%;"><br>
<img src="https://raw.githubusercontent.com/misterdevit/laracheck/refs/heads/main/_art/error_details.png" style="width:100%;"><br>
<img src="https://raw.githubusercontent.com/misterdevit/laracheck/refs/heads/main/_art/outages.png" style="width:100%;">
</center>

#### Installation

-   Clone this repo and install it on your server
-   Configure your `.env` file with your own configuration
-   Configure SMTP email credentals (systems will send notification)
-   Run migrations and seeders `php artisan migrate --seed`
-   Set Cron Jobs `* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`
-   Sign In using `admin@admin.com` / `password` credentials
-   Edit email, password and 2FA into User Profile page

#### Add Sites

-   Create a new Site into Sites area
-   Create an API token via User Profile page
-   Install the Laracheck client into your site: https://github.com/misterdevit/laracheck-client (`composer require misterdevit/laracheck`)
-   Configure your site .env file with API Token, Site ID and your Laracheck `/api/bugs` path (e.g. https://laracheck.site.com/api/bugs)

> In site configuration you can set as option an email to notify both outages and resolutions, an email to notify only outages and another one to notify only resoltions. This is useful if you have to configure third parts status pages.

#### License

Laracheck is an open-source software licensed under the MIT license.

#### Contributing

Thank you for considering contributing to this project (Pull Requests, Issues, Feedbacks, Stars, Promo, Beers) :)

#### Support

Need support with Laracheck? Please open an issue here: https://github.com/misterdevit/laracheck/issues.

<hr>

...enjoy Laracheck :)
