<?php

namespace Minotar\Encoder;

use Minotar\MinotarEncoderInterface;
use Minotar\MinotarAdapterInterface;

class Datauri implements MinotarEncoderInterface
{
    const IMAGE_TYPE = 'png';

    /**
     * @var MinotarAdapterInterface The cache adapter to use
     */
    protected $adapter;

    public function __construct(MinotarAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function make($config, $path)
    {
        $response = $this->adapter->retrieve($config, $path);
        if (!$response) {
            return false;
        }

        $output = base64_encode($response);

        return $this->formatDataURI($output);
    }

    /**
     * Adds appropriate metadata the base64 encoded image
     * @param $data string
     * @return string
     */
    protected function formatDataURI($data)
    {
        return 'data:image/' . self::IMAGE_TYPE . ';base64,' . $data;
    }
} 
