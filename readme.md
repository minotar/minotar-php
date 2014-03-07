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

### Usage

This package is designed to get you off the ground as easily as possible. If you just want to get going, you can call the Display methods simply:

```
	echo Minotar\Minotar::avatar('steve');
	echo Minotar\Minotar::helm('steve', 200);
	echo Minotar\Minotar::skin('steve');
```
Notice what I did on the second line, there. `avatar()` and `helm()` both take a second optional argument, to tell it what size of helm or avatar you'd like. By default, this just echoes out the raw Minotar URL. But you came for caching, and here you go!

To customize the configuration of Minotar, you'll want to first `make()` your own, custom Display object. This can take an array of configuration options. By default, the array looks like:

```
   array(
        'cache'    => null,  // Cache adapter to use
        'time'     => 60,    // Minutes to cache for
        'encoder'  => null' // The output encoder
    );
```

We'll look at each of these options in depth a bit down below.

#### Cache
The cache is what you'll mainly be interested in. Minotar uses the [desarolla2/Cache](https://github.com/desarrolla2/Cache) package to handle its caching, which allows you to cache in file, Apc, Memory, MongoDB, or MySQL. "Memory" is a bit useless here, and you don't want to cache images in MySQL most likely.

To use the file cache, it's as simple as,

```
	$adapter = Minotar\Minotar::adapter('file', your/cache/directory');
	Minotar\Minotar::make(array(
		'cache' => $adapter
	));
```

The first argument is the cache adapter to use ("file", in this case), and every additional argument is fed to the adapter in [desarolla2/Cache](https://github.com/desarrolla2/Cache).

Pretty neat, huh? You can check out [the cache docs](https://github.com/desarrolla2/Cache/blob/master/README.md) if you'd like some more information about each adapter.

#### Time
"Time" is simply the amount of time, in minutes, that you'd like the Minotars to cache for.

#### Encoder
The Encoder is similar in usage to the Cache.

```
	$encoder = Minotar\Minotar::encoder('datauri');
	Minotar\Minotar::make(array(
		'encoder' => $encoder
	));

	// Other adapters and usage
	$encoder = Minotar\Minotar::encoder('raw');
	$encoder = Minotar\Minotar::encoder('url', 'http://example.com/image.php');
```


 - `raw` - This causes the URL of Minotar to be displayed directly, bypassing the server-side cache entirely.
 - `datauri` - This returns a *data URI*, which can be inserted inside an image tag and displayed directly on the page. The disadvantage is that the client's browser will not cache this, but it is quite simple to set up and may be useful in some cases.
 - `url` - This points to a URL on your server, where avatars can be served from (see below for usage).

### URL Cache and Example
The optimum way to set up minotar-php is to cache, is using the `url` encoder. This causes a cache to be formed on both your server *and* on the client's own machine, reducing load all around. I've written a super simple example setup below, which displays my avatar and caches on the server for three hours:

##### minotar.php

```
$encoder = Minotar\Minotar::encoder('url', 'http://example.com/serve.php');
$adapter = Minotar\Minotar::adapter('file', your/cache/directory');

$minotar = Minotar\Minotar::make(array(
	'cache' => $encoder,
	'adapter' =>  $adapter,
	'time' => 60 * 3
));
```

##### index.php
```
include('minotar.php');

$minotar->avatar('connor4312');
```

##### server.php
```
include('minotar.php');

$minotar->serve();
```

### Aaand that's it
Feel free to read through the code if you'd like a better understanding of what's happening. Fork, share, use, and contribute.

### Contributing
To contribute:

- Document your code
- Unit test for any changed functionality/bugfixes
- Please follow PSR-2