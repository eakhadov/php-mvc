<?php

namespace Engine\Core\Template\Extension;

use \Twig\Extension\AbstractExtension;
use \Twig\TwigFunction;

class AssetExtension extends AbstractExtension
{
    /**
     * Undocumented function
     *
     * @return string
     */
    public function getName(): string
    {
        return 'TwigAssetExtensions';
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('asset', [new AssetExtension, 'getAsset']),
        ];
    }

    /**
     * Undocumented function
     *
     * @param string $file
     * @return string
     */
    public function getAsset(string $file): string
    {
        return \Engine\Core\Template\Asset::get($file);
    }
}