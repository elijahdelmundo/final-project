<?php

namespace App\Controllers;

class Media extends BaseController
{
    public function product(string $filename)
    {
        return $this->image('products', $filename);
    }

    public function avatar(string $filename)
    {
        return $this->image('avatars', $filename);
    }

    private function image(string $directory, string $filename)
    {
        $filename = basename($filename);
        $path = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $filename;

        if (! is_file($path)) {
            return $this->response->setStatusCode(404);
        }

        $mime = mime_content_type($path);
        if (! in_array($mime, ['image/jpeg', 'image/png', 'image/webp', 'image/gif'], true)) {
            return $this->response->setStatusCode(404);
        }

        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setHeader('X-Content-Type-Options', 'nosniff')
            ->setBody((string) file_get_contents($path));
    }
}
