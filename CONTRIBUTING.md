![Logo](./media/rc_logo_512.png)

# CONTRIBUTING

## Configure development environment

### Check out project and run composer

```bash
mkdir -p /var/www/textcontrol/txtextcontrol-reportingcloud

cd /var/www/textcontrol/txtextcontrol-reportingcloud

git clone git@github.com:TextControl/txtextcontrol-reportingcloud-php.git .

composer update

composer dump-autoload --optimize
```

### Set up GitHub

Click "Keep my email address private" at https://github.com/settings/emails and use the shown email.

```bash
git config user.name  "John Doe"
git config user.email "johndoe@users.noreply.github.com"
```

## Tag and release version

```bash
git tag release-1.1.x && git push origin --tags
```