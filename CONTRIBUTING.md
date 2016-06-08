![Logo](https://raw.githubusercontent.com/TextControl/txtextcontrol-reportingcloud-php/master/media/rc_logo_512.png)

# Contribute to the ReportingCloud PHP Wrapper

## Configure development environment

```bash
mkdir -p /var/www/textcontrol/txtextcontrol-reportingcloud

cd /var/www/textcontrol/txtextcontrol-reportingcloud

git clone git@github.com:TextControl/txtextcontrol-reportingcloud-php.git .

composer update

composer dump-autoload --optimize
```

## Tag and release version

```bash
git tag release-1.0.x && git push origin --tags
```