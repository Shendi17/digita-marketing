<?php
/**
 * Script de génération automatique d'articles de blog et de formations
 * pour tous les services listés dans liste-services-complets.md
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/Database.php';

class ContentGenerator {
    private $db;
    private $services = [];
    private $categories = [];
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->loadCategories();
        $this->parseServices();
    }
    
    private function loadCategories() {
        $result = $this->db->query('SELECT * FROM service_categories');
        foreach ($result as $cat) {
            $this->categories[$cat['slug']] = $cat;
        }
    }
    
    private function parseServices() {
        $file = __DIR__ . '/../docs/liste-services-complets.md';
        $content = file_get_contents($file);
        
        // Mapping des sections vers les catégories
        $sectionMapping = [
            'RÉSEAUX SOCIAUX' => 'reseaux-sociaux',
            'DESIGN GRAPHIQUE' => 'design-graphique',
            'PRODUCTION VIDÉO' => 'production-video',
            'CRÉATION DE SITES WEB' => 'creation-web',
            'RÉFÉRENCEMENT & SEO' => 'seo',
            'PUBLICITÉ EN LIGNE' => 'publicite-en-ligne',
            'EMAIL MARKETING' => 'email-marketing',
            'ANALYTICS' => 'analytics',
            'STRATÉGIE DIGITALE' => 'strategie-digitale',
            'RÉDACTION' => 'redaction',
            'INTELLIGENCE ARTIFICIELLE' => 'intelligence-artificielle',
            'E-COMMERCE' => 'e-commerce',
            'APPLICATIONS MOBILES' => 'applications-mobiles',
            'FORMATION' => 'formation',
            'SÉCURITÉ' => 'securite',
            'ÉVÉNEMENTIEL' => 'evenementiel',
            'MARKETING D\'INFLUENCE' => 'marketing-influence',
            'RELATION CLIENT' => 'crm'
        ];
        
        // Parser le fichier markdown
        $lines = explode("\n", $content);
        $currentCategory = null;
        $currentSubsection = null;
        
        foreach ($lines as $line) {
            $line = trim($line);
            
            // Détection des sections principales (## TITRE avec ou sans emoji)
            if (preg_match('/^##\s+(.+)$/', $line, $matches)) {
                $sectionTitle = strtoupper(trim($matches[1]));
                // Enlever les emojis
                $sectionTitle = preg_replace('/[\x{1F300}-\x{1F9FF}]/u', '', $sectionTitle);
                $sectionTitle = trim($sectionTitle);
                
                foreach ($sectionMapping as $key => $slug) {
                    if (strpos($sectionTitle, $key) !== false) {
                        $currentCategory = $slug;
                        echo "📂 Catégorie détectée : {$key} → {$slug}\n";
                        break;
                    }
                }
            }
            
            // Détection des sous-sections (### Titre)
            if (preg_match('/^###\s+(.+)$/', $line, $matches)) {
                $currentSubsection = trim($matches[1]);
            }
            
            // Détection des services (lignes commençant par -)
            if (preg_match('/^-\s+(.+)$/', $line, $matches) && $currentCategory) {
                $serviceName = trim($matches[1]);
                // Nettoyer les parenthèses et détails
                $serviceName = preg_replace('/\s*\([^)]*\)/', '', $serviceName);
                
                $this->services[] = [
                    'name' => $serviceName,
                    'category' => $currentCategory,
                    'subsection' => $currentSubsection
                ];
            }
        }
        
        echo "✅ " . count($this->services) . " services détectés\n";
    }
    
    private function generateSlug($text) {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        return trim($text, '-');
    }
    
    private function generateArticleContent($service) {
        $name = $service['name'];
        $category = $this->categories[$service['category']]['name'] ?? 'Marketing Digital';
        
        $content = "# {$name} : Guide Complet\n\n";
        $content .= "## Introduction\n\n";
        $content .= "Le service de **{$name}** est devenu essentiel dans le paysage du marketing digital moderne. ";
        $content .= "Chez Digita, nous vous accompagnons pour mettre en place une stratégie efficace et mesurable.\n\n";
        
        $content .= "## Qu'est-ce que {$name} ?\n\n";
        $content .= "Le {$name} consiste à optimiser votre présence digitale en utilisant des techniques éprouvées ";
        $content .= "et des outils performants. Cette approche permet d'atteindre vos objectifs marketing de manière efficace.\n\n";
        
        $content .= "## Pourquoi choisir {$name} ?\n\n";
        $content .= "### Avantages clés\n\n";
        $content .= "- **ROI mesurable** : Suivez précisément les résultats de vos investissements\n";
        $content .= "- **Ciblage précis** : Atteignez exactement votre audience cible\n";
        $content .= "- **Flexibilité** : Adaptez votre stratégie en temps réel\n";
        $content .= "- **Expertise** : Bénéficiez de notre expérience et de nos compétences\n\n";
        
        $content .= "## Comment mettre en place {$name} ?\n\n";
        $content .= "### Étape 1 : Audit et analyse\n";
        $content .= "Nous commençons par analyser votre situation actuelle, vos objectifs et votre marché.\n\n";
        
        $content .= "### Étape 2 : Stratégie personnalisée\n";
        $content .= "Nous élaborons une stratégie sur-mesure adaptée à vos besoins spécifiques.\n\n";
        
        $content .= "### Étape 3 : Mise en œuvre\n";
        $content .= "Notre équipe d'experts met en place les actions définies dans la stratégie.\n\n";
        
        $content .= "### Étape 4 : Suivi et optimisation\n";
        $content .= "Nous suivons les performances et optimisons continuellement pour maximiser les résultats.\n\n";
        
        $content .= "## Les outils et technologies\n\n";
        $content .= "Nous utilisons les meilleurs outils du marché pour garantir l'efficacité de votre {$name} :\n\n";
        $content .= "- Plateformes professionnelles leaders\n";
        $content .= "- Outils d'analyse avancés\n";
        $content .= "- Technologies d'automatisation\n";
        $content .= "- Dashboards de reporting en temps réel\n\n";
        
        $content .= "## Cas d'usage et exemples\n\n";
        $content .= "De nombreuses entreprises ont déjà bénéficié de notre expertise en {$name}. ";
        $content .= "Nos clients constatent en moyenne une amélioration significative de leurs performances digitales.\n\n";
        
        $content .= "## Tarifs et formules\n\n";
        $content .= "Nous proposons différentes formules adaptées à tous les budgets :\n\n";
        $content .= "- **Formule Starter** : Idéale pour démarrer\n";
        $content .= "- **Formule Business** : Pour les entreprises en croissance\n";
        $content .= "- **Formule Premium** : Solution complète et personnalisée\n\n";
        
        $content .= "## FAQ\n\n";
        $content .= "### Combien de temps faut-il pour voir des résultats ?\n";
        $content .= "Les premiers résultats sont généralement visibles dès les premières semaines, ";
        $content .= "mais l'optimisation complète nécessite généralement 3 à 6 mois.\n\n";
        
        $content .= "### Quel budget prévoir ?\n";
        $content .= "Le budget dépend de vos objectifs et de votre secteur d'activité. ";
        $content .= "Contactez-nous pour un devis personnalisé.\n\n";
        
        $content .= "## Conclusion\n\n";
        $content .= "Le {$name} est un investissement stratégique pour votre entreprise. ";
        $content .= "Avec Digita, vous bénéficiez d'une expertise reconnue et d'un accompagnement personnalisé.\n\n";
        
        $content .= "**Prêt à démarrer ?** [Contactez-nous](/contact) pour discuter de votre projet !\n";
        
        return $content;
    }
    
    private function generateFormationModules($service) {
        $name = $service['name'];
        
        return [
            [
                'title' => "Introduction à {$name}",
                'description' => "Découvrez les fondamentaux et les concepts clés",
                'lessons' => [
                    ['title' => "Qu'est-ce que {$name} ?", 'duration' => 15, 'is_free' => true],
                    ['title' => "Les enjeux et opportunités", 'duration' => 20, 'is_free' => true],
                    ['title' => "Les outils et plateformes", 'duration' => 25, 'is_free' => false],
                    ['title' => "Quiz de validation", 'duration' => 10, 'is_free' => false]
                ]
            ],
            [
                'title' => "Stratégie et planification",
                'description' => "Apprenez à élaborer une stratégie efficace",
                'lessons' => [
                    ['title' => "Définir vos objectifs", 'duration' => 30, 'is_free' => false],
                    ['title' => "Analyser votre audience", 'duration' => 25, 'is_free' => false],
                    ['title' => "Créer votre plan d'action", 'duration' => 35, 'is_free' => false],
                    ['title' => "Exercice pratique", 'duration' => 20, 'is_free' => false]
                ]
            ],
            [
                'title' => "Mise en pratique",
                'description' => "Passez à l'action avec des cas concrets",
                'lessons' => [
                    ['title' => "Configuration et paramétrage", 'duration' => 40, 'is_free' => false],
                    ['title' => "Création de votre première campagne", 'duration' => 45, 'is_free' => false],
                    ['title' => "Optimisation et tests", 'duration' => 30, 'is_free' => false],
                    ['title' => "Projet final", 'duration' => 60, 'is_free' => false]
                ]
            ],
            [
                'title' => "Analyse et optimisation",
                'description' => "Mesurez et améliorez vos performances",
                'lessons' => [
                    ['title' => "Les KPIs essentiels", 'duration' => 25, 'is_free' => false],
                    ['title' => "Outils d'analyse", 'duration' => 30, 'is_free' => false],
                    ['title' => "Optimisation continue", 'duration' => 35, 'is_free' => false],
                    ['title' => "Cas d'études avancés", 'duration' => 40, 'is_free' => false]
                ]
            ],
            [
                'title' => "Techniques avancées",
                'description' => "Maîtrisez les techniques d'expert",
                'lessons' => [
                    ['title' => "Automatisation", 'duration' => 45, 'is_free' => false],
                    ['title' => "Intégrations avancées", 'duration' => 40, 'is_free' => false],
                    ['title' => "Stratégies d'experts", 'duration' => 50, 'is_free' => false],
                    ['title' => "Certification finale", 'duration' => 30, 'is_free' => false]
                ]
            ]
        ];
    }
    
    public function generateAll($limit = null) {
        $count = 0;
        $articlesCreated = 0;
        $formationsCreated = 0;
        
        foreach ($this->services as $service) {
            if ($limit && $count >= $limit) break;
            
            try {
                // Générer l'article
                $articleSlug = $this->generateSlug($service['name']);
                $articleExists = $this->db->fetch(
                    'SELECT id FROM blog_articles WHERE slug = ?',
                    [$articleSlug]
                );
                
                if (!$articleExists) {
                    $content = $this->generateArticleContent($service);
                    $excerpt = substr(strip_tags($content), 0, 200) . '...';
                    
                    $categoryId = $this->categories[$service['category']]['id'] ?? null;
                    
                    $this->db->query(
                        'INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, status, published_at) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, NOW())',
                        [
                            $service['name'] . ' : Guide Complet',
                            $articleSlug,
                            $categoryId,
                            $service['name'],
                            $excerpt,
                            $content,
                            'published'
                        ]
                    );
                    $articlesCreated++;
                    echo "✅ Article créé : {$service['name']}\n";
                }
                
                // Générer la formation
                $formationSlug = 'formation-' . $this->generateSlug($service['name']);
                $formationExists = $this->db->fetch(
                    'SELECT id FROM formations WHERE slug = ?',
                    [$formationSlug]
                );
                
                if (!$formationExists) {
                    $categoryId = $this->categories[$service['category']]['id'] ?? null;
                    $modules = $this->generateFormationModules($service);
                    $totalDuration = 0;
                    
                    foreach ($modules as $module) {
                        foreach ($module['lessons'] as $lesson) {
                            $totalDuration += $lesson['duration'];
                        }
                    }
                    
                    $this->db->query(
                        'INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, status) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
                        [
                            'Formation ' . $service['name'],
                            $formationSlug,
                            $categoryId,
                            $service['name'],
                            "Formation complète pour maîtriser {$service['name']} de A à Z. Apprenez les techniques professionnelles et passez à l'action avec des cas pratiques.",
                            'intermediaire',
                            ceil($totalDuration / 60),
                            297.00,
                            'published'
                        ]
                    );
                    
                    $formationId = $this->db->getConnection()->lastInsertId();
                    
                    // Créer les modules et leçons
                    foreach ($modules as $index => $module) {
                        $this->db->query(
                            'INSERT INTO formation_modules (formation_id, title, description, order_num) VALUES (?, ?, ?, ?)',
                            [$formationId, $module['title'], $module['description'], $index + 1]
                        );
                        
                        $moduleId = $this->db->getConnection()->lastInsertId();
                        
                        foreach ($module['lessons'] as $lessonIndex => $lesson) {
                            $this->db->query(
                                'INSERT INTO formation_lessons (module_id, title, order_num, duration_minutes, is_free) 
                                 VALUES (?, ?, ?, ?, ?)',
                                [
                                    $moduleId,
                                    $lesson['title'],
                                    $lessonIndex + 1,
                                    $lesson['duration'],
                                    $lesson['is_free'] ? 1 : 0
                                ]
                            );
                        }
                    }
                    
                    $formationsCreated++;
                    echo "✅ Formation créée : Formation {$service['name']}\n";
                }
                
                $count++;
                
            } catch (Exception $e) {
                echo "❌ Erreur pour {$service['name']}: " . $e->getMessage() . "\n";
            }
        }
        
        echo "\n";
        echo "========================================\n";
        echo "✅ Génération terminée !\n";
        echo "📝 Articles créés : {$articlesCreated}\n";
        echo "🎓 Formations créées : {$formationsCreated}\n";
        echo "========================================\n";
    }
}

// Exécution
echo "🚀 Démarrage de la génération de contenu...\n\n";

$generator = new ContentGenerator();

// Générer tout le contenu (ou limiter avec un nombre)
// $generator->generateAll(10); // Limiter à 10 pour tester
$generator->generateAll(); // Générer tout

echo "\n✅ Script terminé !\n";
