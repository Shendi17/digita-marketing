# ✨ Standards d'Excellence DIGITA

Ce document définit les normes de réalisation pour maintenir DIGITA au plus haut niveau de qualité du marché (Paroxisme). Toute nouvelle implémentation doit s'y conformer.

---

## 1. Standards UI/UX (Aesthetics)
Le design doit être **Wow** dès le premier regard.

*   **Palette de Couleurs** :
    *   `--dark` : #050505 (Fond profond)
    *   `--premium-blue` : #00d2ff (Énergie, IA)
    *   `--gold` : #D4AF37 (Prestige, Conseil)
*   **Glassmorphism** : Utiliser la classe `.glass-card`.
    *   `backdrop-filter: blur(15px);`
    *   `background: rgba(255, 255, 255, 0.03);`
    *   `border: 1px solid rgba(255, 255, 255, 0.1);`
*   **Animations** : Utiliser `AOS` (Animate On Scroll) pour chaque section majeure.
    *   Privilégier `fade-up`, `zoom-in` et les délais (`data-aos-delay="100"`).

---

## 2. Standards de Code (Performance)
*   **Mobile First** : Toutes les sections fusionnées doivent être testées sur mobile.
*   **Chargement Asynchrone** : Le système de particules (`premiumParticles`) doit être optimisé pour ne pas ralentir le scroll.
*   **Variables CSS** : Ne jamais utiliser de couleurs "hardcoded". Utiliser les variables définies dans le layout principal.

---

## 3. Standards IA (Intelligence)
Tout nouvel agent ou fonctionnalité IA doit :
*   **Reconnaître le contexte** : Toujours vérifier si un contexte client existe via `ContextManager`.
*   **Ton Stratégique** : Éviter le ton "assistant robotique". Utiliser un ton de "Partner Consultant Senior".
*   **Expertise Spécifique** : Les agents ne doivent pas être généralistes. Ils doivent porter une expertise (SEO, Stratégie, etc.).

---

## 4. Maintenance & Evolution
*   **Formations** : Les liens de formation dans les articles doivent être encapsulés dans des widgets premium pour garantir leur visibilité et leur persistance.
*   **Analyse de Performance** : Chaque interaction clé (Validation de brief, clic sur audit) doit être tracée ou prête à l'être pour calculer le ROI.

---

> [!IMPORTANT]
> L'excellence n'est pas une option, c'est la norme. Si un composant semble "standard", il doit être sublimé.
