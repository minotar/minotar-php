<?php

namespace Minotar\Encoder;

use Minotar\MinotarEncoderInterface;

class Datauri implements MinotarEncoderInterface
{
    const IMAGE_TYPE = 'png';

    public function make($data)
    {
        $output = base64_encode($data);

        return $this->formatDataURI($output);
    }

    /**
     * Adds appropriate metadata the base64 encoded image
     * @param $data
     * @return string
     */
    protected function formatDataURI($data)
    {
        return 'data:image/' . self::IMAGE_TYPE . ';base64,' . $data;
    }
} 
