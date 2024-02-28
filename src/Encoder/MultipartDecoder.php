<?php

namespace App\Encoder;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

final class MultipartDecoder implements DecoderInterface
{
    public const FORMAT = 'multipart';

    public function __construct(private RequestStack $requestStack)
    {
    }

    public function decode(string $data, string $format, array $context = []): ?array
    {
        $request = $this->requestStack->getCurrentRequest();

        $request->request->set('duration', (int) $request->request->get('duration'));
        $request->request->set('entries', (int) $request->request->get('entries'));
        $request->request->set('budget', (int) $request->request->get('budget'));
        $request->request->set('note', (float) $request->request->get('note'));
        $request->request->set('online', (bool) $request->request->get('online'));

        if (!$request) {
            return null;
        }

        $array = array_map(static function ($element) {
            // Multipart form values will be encoded in JSON.
            $decoded = json_decode($element, true);

            return \is_array($decoded) ? $decoded : $element;
        }, $request->request->all()) + $request->files->all();

        return $array;
    }

    public function supportsDecoding(string $format): bool
    {
        return self::FORMAT === $format;
    }
}