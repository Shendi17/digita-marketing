# 🏛️ Manifeste DIGITA : Excellence Digitale & IA

Ce document constitue la référence stratégique et technique du projet **DIGITA**. Il définit l'architecture d'intelligence et les standards de performance du "Cabinet de Conseil Augmenté".

---

## 1. Vision Stratégique
DIGITA n'est pas une agence web classique, c'est un **Cabinet de Conseil Stratégique**. 
L'objectif est de transformer chaque visiteur en client via un parcours d'expertise soutenu par l'Intelligence Artificielle.

### piliers de la Marque :
*   **Prestige** : Un design épuré, sombre, avec des accents Or et des effets de Glassmorphism.
*   **Intelligence** : Une plateforme qui "comprend" le business du client (Memory System).
*   **Performance** : Conversion orientée vers le ROI et l'automatisation.

---

## 2. Architecture de l'Intelligence (Phases 1-3)

### A. L'Orchestrateur Multi-Agents (`AgentOrchestrator.php`)
Ce service est le cerveau du système. Il route les requêtes en fonction de l'intention :
*   **Agent Stratégique** : Conseil business et vision globale.
*   **Agent SEO** : Optimisation de visibilité et performance technique.
*   **Agent Créatif** : Branding, UI/UX et identité.

### B. Le Gestionnaire de Contexte (`ContextManager.php`)
Permet de conserver une mémoire persistante des besoins du client :
*   Extraction auto des buts business, audience cible et points de douleur.
*   Partage du contexte entre le Chatbot, le Formulaire de Brief et le Dashboard.

### C. L'Espace Performance (Dashboard)
Transforme les données froides en indicateurs stratégiques :
*   **Score de Maturité Digitale** : Calculé dynamiquement pour engager le client.
*   **Widget Insights** : Récapitulatif IA du profil business analysé.

---

## 3. Inventaire Technique Majeur

| Composant | Rôle | Localisation |
| :--- | :--- | :--- |
| **AIService** | Abstraction API LLM | `app/Services/AIService.php` |
| **AgentOrchestrator** | Routage Multi-Agents | `app/Services/AgentOrchestrator.php` |
| **ContextManager** | Mémoire Contextuelle | `app/Services/ContextManager.php` |
| **Atelier Stratégique** | Formulaire de Brief Premium | `app/Views/projects/brief-form.php` |
| **Cockpit Client** | Dashboard Engagement | `app/Views/projects/client-dashboard.php` |

---

## 4. Plan de Scalabilité (Futur)

### Phase 4 : SEO Dynamic & Content Engine
*   Génération automatique d'articles de blog alignés sur le brief client.
*   Maillage interne intelligent vers les formations recommandées.

### Phase 5 : Intégrations Profondes
*   Liaison API avec les CRM et outils d'automation marketing tiers.
*   Connecteur Webox pour le previewing de sites générés.

---

> [!TIP]
> Pour maintenir ce niveau d'excellence, toute nouvelle fonctionnalité doit respecter les [Standards Premium](file:///C:/Users/Anthony/CascadeProjects/digita-marketing/docs/STANDARDS_PREMIUM.md).
