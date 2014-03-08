<?php

namespace Minotar\Encoder;

use Symfony\Component\HttpFoundation\Response;
use Minotar\MinotarEncoderInterface;
use Minotar\MinotarAdapterInterface;

class Server implements MinotarEncoderInterface
{
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
        $image = $this->adapter->retrieve($config, $path);
        if (!$image) {
            return $this->generate400();
        }

        return $this->generateReponse($config, $image);
    }

    /**
     * Creates a Symfony response, and apply appropriate caching headers
     * @param $config array
     * @param $image string
     * @return Response
     */
    protected function generateReponse($config, $image)
    {
        $response = new Response($image, 200, array('Content-Type' => 'image/png'));

        $response->setPublic();
        $response->setMaxAge($config['time']);
        $response->setSharedMaxAge($config['time']);

        return $response;
    }

    /**
     * Creates a 400 error response, for an unsuccessful request.
     * @return Response
     */
    protected function generate400()
    {
        return new Response('', 400);
    }
}
