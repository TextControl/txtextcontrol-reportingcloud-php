#!/usr/bin/env bash

RC_PATH=~/libs/textcontrol/txtextcontrol-reportingcloud
GH_PATH=~/libs/textcontrol/txtextcontrol-reportingcloud-gh-pages


rm -fr ~/libs/textcontrol/txtextcontrol-reportingcloud-gh-pages

git clone git@github.com:TextControl/txtextcontrol-reportingcloud-php.git                                              \
    --branch gh-pages ~/libs/textcontrol/txtextcontrol-reportingcloud-gh-pages

# ----------------------------------------------------------------------------------------------------------------------

# composer global require phpdocumentor/phpdocumentor

~/.composer/vendor/bin/phpdoc run    \
    --directory ${RC_PATH}/src       \
    --target    ${GH_PATH}/docs-api  \
    --template clean

git add .

git commit -am"Updated API documentation"

git push origin gh-pages

# ----------------------------------------------------------------------------------------------------------------------

#git add .

#git commit -am"Updated test coverage documentation"

#git push origin gh-pages
