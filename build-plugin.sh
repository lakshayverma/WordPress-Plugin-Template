#!/bin/bash

printf "Plugin name: "
read NAME

printf "Destination folder: "
read FOLDER

printf "Include Grunt support (y/n): "
read GRUNT

printf "Initialise new git repo (y/n): "
read NEWREPO

DEFAULT_NAME="WordPress Plugin Template"
DEFAULT_CLASS=${DEFAULT_NAME// /_}
DEFAULT_TOKEN=$( tr '[A-Z]' '[a-z]' <<< $DEFAULT_CLASS)
DEFAULT_SLUG=${DEFAULT_TOKEN//_/-}

CLASS=${NAME// /_}
TOKEN=$( tr '[A-Z]' '[a-z]' <<< $CLASS)
SLUG=${TOKEN//_/-}

git clone https://github.com/lakshayverma/$DEFAULT_SLUG.git $FOLDER/$SLUG

echo "Removing git files..."

mkdir -p $FOLDER
cd $FOLDER/$SLUG

rm -rf .git
rm README.md
rm build-plugin.sh
rm changelog.txt

if [ "$GRUNT" == "n" ]; then
	rm Gruntfile.js
	rm package.json
fi

echo "Updating plugin files..."

mv $DEFAULT_SLUG.php $SLUG.php

cp $SLUG.php $SLUG.tmp
sed "s/$DEFAULT_NAME/$NAME/g" $SLUG.tmp > $SLUG.php
rm $SLUG.tmp

cp $SLUG.php $SLUG.tmp
sed "s/$DEFAULT_SLUG/$SLUG/g" $SLUG.tmp > $SLUG.php
rm $SLUG.tmp

cp $SLUG.php $SLUG.tmp
sed "s/$DEFAULT_TOKEN/$TOKEN/g" $SLUG.tmp > $SLUG.php
rm $SLUG.tmp

cp $SLUG.php $SLUG.tmp
sed "s/$DEFAULT_CLASS/$CLASS/g" $SLUG.tmp > $SLUG.php
rm $SLUG.tmp

cp readme.plugin.md readme.tmp
sed "s/$DEFAULT_NAME/$NAME/g" readme.tmp > README.md
rm readme.tmp


cd lang
mv $DEFAULT_SLUG.pot $SLUG.pot

cp $SLUG.pot $SLUG.tmp
sed "s/$DEFAULT_NAME/$NAME/g" $SLUG.tmp > $SLUG.pot
rm $SLUG.tmp

cp $SLUG.pot $SLUG.tmp
sed "s/$DEFAULT_CLASS/$CLASS/g" $SLUG.tmp > $SLUG.pot
rm $SLUG.tmp

cp $SLUG.pot $SLUG.tmp
sed "s/$DEFAULT_TOKEN/$TOKEN/g" $SLUG.tmp > $SLUG.pot
rm $SLUG.tmp

cp $SLUG.pot $SLUG.tmp
sed "s/$DEFAULT_SLUG/$SLUG/g" $SLUG.tmp > $SLUG.pot
rm $SLUG.tmp


cd ../includes
mv class-$DEFAULT_SLUG.php class-$SLUG.php

cp class-$SLUG.php class-$SLUG.tmp
sed "s/$DEFAULT_CLASS/$CLASS/g" class-$SLUG.tmp > class-$SLUG.php
rm class-$SLUG.tmp

cp class-$SLUG.php class-$SLUG.tmp
sed "s/$DEFAULT_TOKEN/$TOKEN/g" class-$SLUG.tmp > class-$SLUG.php
rm class-$SLUG.tmp

cp class-$SLUG.php class-$SLUG.tmp
sed "s/$DEFAULT_SLUG/$SLUG/g" class-$SLUG.tmp > class-$SLUG.php
rm class-$SLUG.tmp


mv class-$DEFAULT_SLUG-settings.php class-$SLUG-settings.php

cp class-$SLUG-settings.php class-$SLUG-settings.tmp
sed "s/$DEFAULT_CLASS/$CLASS/g" class-$SLUG-settings.tmp > class-$SLUG-settings.php
rm class-$SLUG-settings.tmp

cp class-$SLUG-settings.php class-$SLUG-settings.tmp
sed "s/$DEFAULT_TOKEN/$TOKEN/g" class-$SLUG-settings.tmp > class-$SLUG-settings.php
rm class-$SLUG-settings.tmp

cp class-$SLUG-settings.php class-$SLUG-settings.tmp
sed "s/$DEFAULT_SLUG/$SLUG/g" class-$SLUG-settings.tmp > class-$SLUG-settings.php
rm class-$SLUG-settings.tmp

mv class-$DEFAULT_SLUG-page.php class-$SLUG-page.php

cp class-$SLUG-page.php class-$SLUG-page.tmp
sed "s/$DEFAULT_CLASS/$CLASS/g" class-$SLUG-page.tmp > class-$SLUG-page.php
rm class-$SLUG-page.tmp

cp class-$SLUG-page.php class-$SLUG-page.tmp
sed "s/$DEFAULT_TOKEN/$TOKEN/g" class-$SLUG-page.tmp > class-$SLUG-page.php
rm class-$SLUG-page.tmp

cp class-$SLUG-page.php class-$SLUG-page.tmp
sed "s/$DEFAULT_SLUG/$SLUG/g" class-$SLUG-page.tmp > class-$SLUG-page.php
rm class-$SLUG-page.tmp


cd lib
mv class-$DEFAULT_SLUG-post-type.php class-$SLUG-post-type.php

cp class-$SLUG-post-type.php class-$SLUG-post-type.tmp
sed "s/$DEFAULT_CLASS/$CLASS/g" class-$SLUG-post-type.tmp > class-$SLUG-post-type.php
rm class-$SLUG-post-type.tmp

cp class-$SLUG-post-type.php class-$SLUG-post-type.tmp
sed "s/$DEFAULT_TOKEN/$TOKEN/g" class-$SLUG-post-type.tmp > class-$SLUG-post-type.php
rm class-$SLUG-post-type.tmp

cp class-$SLUG-post-type.php class-$SLUG-post-type.tmp
sed "s/$DEFAULT_SLUG/$SLUG/g" class-$SLUG-post-type.tmp > class-$SLUG-post-type.php
rm class-$SLUG-post-type.tmp


mv class-$DEFAULT_SLUG-taxonomy.php class-$SLUG-taxonomy.php

cp class-$SLUG-taxonomy.php class-$SLUG-taxonomy.tmp
sed "s/$DEFAULT_CLASS/$CLASS/g" class-$SLUG-taxonomy.tmp > class-$SLUG-taxonomy.php
rm class-$SLUG-taxonomy.tmp

cp class-$SLUG-taxonomy.php class-$SLUG-taxonomy.tmp
sed "s/$DEFAULT_TOKEN/$TOKEN/g" class-$SLUG-taxonomy.tmp > class-$SLUG-taxonomy.php
rm class-$SLUG-taxonomy.tmp

cp class-$SLUG-taxonomy.php class-$SLUG-taxonomy.tmp
sed "s/$DEFAULT_SLUG/$SLUG/g" class-$SLUG-taxonomy.tmp > class-$SLUG-taxonomy.php
rm class-$SLUG-taxonomy.tmp


mv class-$DEFAULT_SLUG-admin-api.php class-$SLUG-admin-api.php

cp class-$SLUG-admin-api.php class-$SLUG-admin-api.tmp
sed "s/$DEFAULT_CLASS/$CLASS/g" class-$SLUG-admin-api.tmp > class-$SLUG-admin-api.php
rm class-$SLUG-admin-api.tmp

cp class-$SLUG-admin-api.php class-$SLUG-admin-api.tmp
sed "s/$DEFAULT_TOKEN/$TOKEN/g" class-$SLUG-admin-api.tmp > class-$SLUG-admin-api.php
rm class-$SLUG-admin-api.tmp

cp class-$SLUG-admin-api.php class-$SLUG-admin-api.tmp
sed "s/$DEFAULT_SLUG/$SLUG/g" class-$SLUG-admin-api.tmp > class-$SLUG-admin-api.php
rm class-$SLUG-admin-api.tmp



mv class-$DEFAULT_SLUG-general-helper.php class-$SLUG-general-helper.php

cp class-$SLUG-general-helper.php class-$SLUG-general-helper.tmp
sed "s/$DEFAULT_CLASS/$CLASS/g" class-$SLUG-general-helper.tmp > class-$SLUG-general-helper.php
rm class-$SLUG-general-helper.tmp

cp class-$SLUG-general-helper.php class-$SLUG-general-helper.tmp
sed "s/$DEFAULT_TOKEN/$TOKEN/g" class-$SLUG-general-helper.tmp > class-$SLUG-general-helper.php
rm class-$SLUG-general-helper.tmp

cp class-$SLUG-general-helper.php class-$SLUG-general-helper.tmp
sed "s/$DEFAULT_SLUG/$SLUG/g" class-$SLUG-general-helper.tmp > class-$SLUG-general-helper.php
rm class-$SLUG-general-helper.tmp


mv class-$DEFAULT_SLUG-post-meta-helper.php class-$SLUG-post-meta-helper.php

cp class-$SLUG-post-meta-helper.php class-$SLUG-post-meta-helper.tmp
sed "s/$DEFAULT_CLASS/$CLASS/g" class-$SLUG-post-meta-helper.tmp > class-$SLUG-post-meta-helper.php
rm class-$SLUG-post-meta-helper.tmp

cp class-$SLUG-post-meta-helper.php class-$SLUG-post-meta-helper.tmp
sed "s/$DEFAULT_TOKEN/$TOKEN/g" class-$SLUG-post-meta-helper.tmp > class-$SLUG-post-meta-helper.php
rm class-$SLUG-post-meta-helper.tmp

cp class-$SLUG-post-meta-helper.php class-$SLUG-post-meta-helper.tmp
sed "s/$DEFAULT_SLUG/$SLUG/g" class-$SLUG-post-meta-helper.tmp > class-$SLUG-post-meta-helper.php
rm class-$SLUG-post-meta-helper.tmp


mv class-$DEFAULT_SLUG-shortcode-helper.php class-$SLUG-shortcode-helper.php

cp class-$SLUG-shortcode-helper.php class-$SLUG-shortcode-helper.tmp
sed "s/$DEFAULT_CLASS/$CLASS/g" class-$SLUG-shortcode-helper.tmp > class-$SLUG-shortcode-helper.php
rm class-$SLUG-shortcode-helper.tmp

cp class-$SLUG-shortcode-helper.php class-$SLUG-shortcode-helper.tmp
sed "s/$DEFAULT_TOKEN/$TOKEN/g" class-$SLUG-shortcode-helper.tmp > class-$SLUG-shortcode-helper.php
rm class-$SLUG-shortcode-helper.tmp

cp class-$SLUG-shortcode-helper.php class-$SLUG-shortcode-helper.tmp
sed "s/$DEFAULT_SLUG/$SLUG/g" class-$SLUG-shortcode-helper.tmp > class-$SLUG-shortcode-helper.php
rm class-$SLUG-shortcode-helper.tmp


mv trait-$DEFAULT_SLUG-cors.php trait-$SLUG-cors.php

cp trait-$SLUG-cors.php trait-$SLUG-cors.tmp
sed "s/$DEFAULT_CLASS/$CLASS/g" trait-$SLUG-cors.tmp > trait-$SLUG-cors.php
rm trait-$SLUG-cors.tmp

cp trait-$SLUG-cors.php trait-$SLUG-cors.tmp
sed "s/$DEFAULT_TOKEN/$TOKEN/g" trait-$SLUG-cors.tmp > trait-$SLUG-cors.php
rm trait-$SLUG-cors.tmp

cp trait-$SLUG-cors.php trait-$SLUG-cors.tmp
sed "s/$DEFAULT_SLUG/$SLUG/g" trait-$SLUG-cors.tmp > trait-$SLUG-cors.php
rm trait-$SLUG-cors.tmp



if [ "$NEWREPO" == "y" ]; then
	echo "Initialising new git repo..."
	cd ../..
	git init
fi

echo "Complete!"
