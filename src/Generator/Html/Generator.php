<?php

declare(strict_types=1);

namespace Mbiz\Dobble\Generator\Html;

use Mbiz\Dobble\DeckInterface;
use Mbiz\Dobble\Generator\GeneratorInterface;
use Twig\Environment as TwigEnvironment;
use Twig\Loader\FilesystemLoader as TwigFilesystemLoader;

class Generator implements GeneratorInterface
{
    const TEMPLATE_FOLDER = 'templates';
    const CACHER_FOLDER = 'cache';

    /** @var string */
    private $outputDirectory;

    /**
     * Generator constructor.
     *
     * @param string $outputDirectory
     */
    public function __construct(string $outputDirectory)
    {
        $this->outputDirectory = $outputDirectory;
    }
    
    /**
     * @param DeckInterface $deck
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function generate(DeckInterface $deck): void
    {
        if (!is_dir($this->outputDirectory)) {
            mkdir($this->outputDirectory);
        }
    
        $loader = new TwigFilesystemLoader(self::TEMPLATE_FOLDER);
        $twig = new TwigEnvironment($loader, [
            'cache' => self::CACHER_FOLDER,
        ]);
        
        file_put_contents(
            sprintf('%s/%s', $this->outputDirectory, 'index.html'),
            $twig->render('deck.html.twig', ['deck' => $deck])
        );
    }
}
