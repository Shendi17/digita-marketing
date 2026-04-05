<?php
/**
 * Script de génération automatique du sitemap XML
 * À exécuter quotidiennement via CRON: 0 4 * * *
 */

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../app/Models/Article.php';
require_once __DIR__ . '/../../app/Models/Formation.php';

$articleModel = new Article();
$formationModel = new Formation();

$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

// Pages statiques
$staticPages = [
    ['url' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
    ['url' => '/services', 'priority' => '0.9', 'changefreq' => 'weekly'],
    ['url' => '/formations', 'priority' => '0.9', 'changefreq' => 'daily'],
    ['url' => '/blog', 'priority' => '0.9', 'changefreq' => 'daily'],
    ['url' => '/boutique', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['url' => '/solutions', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['url' => '/catalogue', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['url' => '/tarifs', 'priority' => '0.8', 'changefreq' => 'monthly'],
    ['url' => '/a-propos', 'priority' => '0.7', 'changefreq' => 'monthly'],
    ['url' => '/contact', 'priority' => '0.8', 'changefreq' => 'monthly'],
    ['url' => '/mentions-legales', 'priority' => '0.3', 'changefreq' => 'yearly'],
    ['url' => '/politique-confidentialite', 'priority' => '0.3', 'changefreq' => 'yearly'],
    ['url' => '/conditions-generales', 'priority' => '0.3', 'changefreq' => 'yearly'],
];

foreach ($staticPages as $page) {
    $url = $xml->addChild('url');
    $url->addChild('loc', APP_URL . $page['url']);
    $url->addChild('changefreq', $page['changefreq']);
    $url->addChild('priority', $page['priority']);
    $url->addChild('lastmod', date('Y-m-d'));
}

// Articles de blog
$articles = $articleModel->getAllPublished();
foreach ($articles as $article) {
    $url = $xml->addChild('url');
    $url->addChild('loc', APP_URL . '/blog/' . $article['slug']);
    $url->addChild('changefreq', 'weekly');
    $url->addChild('priority', '0.7');
    $url->addChild('lastmod', date('Y-m-d', strtotime($article['updated_at'])));
}

// Catégories blog
$blogCategories = $articleModel->getCategories();
foreach ($blogCategories as $cat) {
    $url = $xml->addChild('url');
    $url->addChild('loc', APP_URL . '/blog/categorie/' . $cat['slug']);
    $url->addChild('changefreq', 'weekly');
    $url->addChild('priority', '0.6');
    $url->addChild('lastmod', date('Y-m-d'));
}

// Formations
$formations = $formationModel->getAllPublished();
foreach ($formations as $formation) {
    $url = $xml->addChild('url');
    $url->addChild('loc', APP_URL . '/formations/' . $formation['slug']);
    $url->addChild('changefreq', 'weekly');
    $url->addChild('priority', '0.8');
    $lastmod = $formation['updated_at'] ?? $formation['created_at'] ?? date('Y-m-d');
    $url->addChild('lastmod', date('Y-m-d', strtotime($lastmod)));
}

// Catégories formations
$formationCategories = $formationModel->getCategories();
foreach ($formationCategories as $cat) {
    $url = $xml->addChild('url');
    $url->addChild('loc', APP_URL . '/formations/categorie/' . $cat['slug']);
    $url->addChild('changefreq', 'weekly');
    $url->addChild('priority', '0.6');
    $url->addChild('lastmod', date('Y-m-d'));
}

// Sauvegarder le sitemap
$sitemapPath = __DIR__ . '/../../public/sitemap.xml';
$xml->asXML($sitemapPath);

$totalUrls = count($staticPages) + count($articles) + count($blogCategories) + count($formations) + count($formationCategories);
echo "Sitemap genere: {$sitemapPath}\n";
echo "  - Pages statiques: " . count($staticPages) . "\n";
echo "  - Articles: " . count($articles) . "\n";
echo "  - Categories blog: " . count($blogCategories) . "\n";
echo "  - Formations: " . count($formations) . "\n";
echo "  - Categories formations: " . count($formationCategories) . "\n";
echo "  - Total URLs: " . $totalUrls . "\n";
