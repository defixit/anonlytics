![License](https://img.shields.io/badge/license-MIT-blue?style=flat-square)
# Anonlytics
In a world with all GDPR rules, an IP address is now already labeled as personal information and can therefore not just be passed on by your website/application.

That's why we introduce Anonlytics, the server side analytics tool that only works with anonymized data for website analytics.

Entirely in accordance with all the rules of the GDPR. Our servers are all located in Europe and no IP addresses are used anywhere.

This Symfony Bundle is part of https://anonlytics.eu, you need a (free) account to use this bundle for your website/application.

## Installation
Use composer to add the library as dependency for your project

`composer require defixit/anonlytics-bundle`

## Usage

### Setup
At first, you need to create an account on [Anonlytics.eu](https://anonlytics.eu) to get your `client_token` and `site_token` to connect to our services.

After you created an account on our website you can create a file with the name `anonlytics.yaml` in the `config/packages/` folder, with the following content:

```yaml
anonlytics:
  client_token: {YOUR_CLIENT_TOKEN}
  site_token: {YOUR_SITE_TOKEN}
```

Also add the following line to your `bundles.php`:

```php
DeFixIT\AnonlyticsBundle\AnonlyticsBundle::class => ['all' => true],
```

After this the bundle is set up and ready to connect and send the data to our service.

### For now this bundle is still in Beta, but we are working hard to get the final release asap. (approx. May 2022)