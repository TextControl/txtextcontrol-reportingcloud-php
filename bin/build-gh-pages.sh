#!/usr/bin/env bash

RC_PATH=~/libs/textcontrol/txtextcontrol-reportingcloud
GH_PATH=~/libs/textcontrol/txtextcontrol-reportingcloud-gh

# ----------------------------------------------------------------------------------------------------------------------

rm -fr ${GH_PATH}

git clone git@github.com:TextControl/txtextcontrol-reportingcloud-php.git --branch gh-pages ${GH_PATH}

# ----------------------------------------------------------------------------------------------------------------------

# composer global require phpdocumentor/phpdocumentor

rm -fr ${GH_PATH}/docs-api

mkdir -p ${GH_PATH}/docs-api

~/.composer/vendor/bin/phpdoc run --directory ${RC_PATH}/src --target ${GH_PATH}/docs-api --template clean

cd ${GH_PATH}

git add .

git commit -am"Updated API documentation"

git push origin gh-pages

# ----------------------------------------------------------------------------------------------------------------------

cd ${RC_PATH}

rm -fr ${GH_PATH}/test-coverage

mkdir -p ${GH_PATH}/test-coverage

./vendor/bin/phpunit --coverage-html ${GH_PATH}/test-coverage

cd ${GH_PATH}/test-coverage

# GitHub pages will not serve
# from hidden directories,
# hence we rename them
mv .css   css
mv .js    js
mv .icons icons

# and update all HTML files
find * -name '*.html' | xargs perl -pi -e "s/\.css\//css\//sig;"
find * -name '*.html' | xargs perl -pi -e "s/\.js\//js\//sig;"
find * -name '*.html' | xargs perl -pi -e "s/\.icons\//icons\//sig;"

cd ${GH_PATH}

git add .

git commit -am"Updated test coverage"

git push origin gh-pages

# ----------------------------------------------------------------------------------------------------------------------
