#Minotar-PHP

As much as we'd like it to be, if you've used Minotar for a length of time, you'll know that it isn't the most reliable service, out-of-the-box. After all, it is a free service, and is used by some of the most popular Minecraft sites on the net, so it takes a good bit of load.

This is a nice, not-too fussy package for handling the display of Minotars on your site with caching, so that whenever your site is up, you should be able to display Minotars.

###Installation

This comes as a [Composer](https://getcomposer.org/doc/00-intro.md) package. Composer is an awesome tool for managing your dependencies in PHP projects; you should definitely start using it, if you aren't already! Simply adding the follow lines to your composer.json...

```
    "require": {
        "minotar/minotar-php": "dev-master",
    },
```

## Example
This is a basic example, showing how one would cache Minotars to your server, and define a page to serve them off of.

#### minotar.php

```
// First, we want to set the "encoder" to use for display...
Minotar\Minotar::encoder('url', 'http://example.com/serve.php');
// And the "adapter" to use for caching
Minotar\Minotar::adapter('file', your/cache/directory');

$minotar = Minotar\Minotar::make(array(
	'time' => 60
));
```

##### index.php
```
include('minotar.php');

$minotar->avatar('connor4312');
```

##### serve.php
```
include('minotar.php');

$minotar->serve();
```

Not too hard, eh? Read on for some more fun and advanced usage.

##Components
The three primary components of minotar-php are the *adapters*, *encoders*, and the MinotarDisplay itself. These are accessed through a facade, `Minotar\Minotar` that passes off appropriate calls.

### Minotar::adapter
`Minotar::adapter($name, $arguments...)` is actually a proxy to [desarrolla2/Cache](https://github.com/desarrolla2/Cache) adapters.

First you pass in the name, such as "file", or "mongo", to give some examples (see the full list on the package's Github page). If you pass in additional arguments, these will be given to the constructor of the cache. Calling `Minotar::adapter('file', '/directory')` is the equivalent of saying `$adapter = new File($cacheDir);`

After you call this function, subsequent MinotarDisplays that are made will use the formed adapter. `Minotar::adapter` also returns the adapter, allowing you to add additional options or make changes if needed. Again, see the documentation on the Cache package if you're interested in that.

### Minotar::encoder
`Minotar::encoder($name, $arguments...)` is similar in construction to the `adapter()`. MinotarDisplays use the last formed adapter, and an instance of the adapter is returned. This essentially defines how images will be displayed on your site.

 - `Minotar::encoder('url', 'http://example.com/path/to/serve.php')` - Using the "url" adapter tells Minotar that you are caching and want to serve the images locally, off the given URL.
 - `Minotar::encoder('raw')` - Using the "raw" encoder will simply cause the default Minotar URL to be displayed.
 - `Minotar::encoder('datauri')` - Using the "datauri" encoder causes Minotars to be, expected, displayed as [Data URIs](http://css-tricks.com/data-uris/). This may be useful in some cases, and is quite easy to set up. The primary disadvantage is that the client's browser will not cache the displayed Minotars. It may be desirable to use in some cases, such as displaying many small Minotars, for example.

## Closing Remarks

Feel free to read through the code if you'd like a better understanding of what's happening. Fork, share, use, and contribute.

### Contributing
To contribute:

- Document your code
- Unit test for any changed functionality/bugfixes
- Please follow PSR-2