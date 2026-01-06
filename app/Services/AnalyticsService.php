<?php

/**
 * Service Analytics
 * Gère le tracking Google Analytics, Facebook Pixel et événements personnalisés
 */
class AnalyticsService {
    
    private $gaTrackingId;
    private $fbPixelId;
    
    public function __construct() {
        $this->gaTrackingId = Environment::get('GA_TRACKING_ID', '');
        $this->fbPixelId = Environment::get('FB_PIXEL_ID', '');
    }
    
    /**
     * Générer le script Google Analytics
     */
    public function getGoogleAnalyticsScript() {
        if (empty($this->gaTrackingId)) {
            return '';
        }
        
        return <<<HTML
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={$this->gaTrackingId}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{$this->gaTrackingId}', {
    'send_page_view': true,
    'anonymize_ip': true
  });
</script>
HTML;
    }
    
    /**
     * Générer le script Facebook Pixel
     */
    public function getFacebookPixelScript() {
        if (empty($this->fbPixelId)) {
            return '';
        }
        
        return <<<HTML
<!-- Facebook Pixel -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '{$this->fbPixelId}');
  fbq('track', 'PageView');
</script>
<noscript>
  <img height="1" width="1" style="display:none"
       src="https://www.facebook.com/tr?id={$this->fbPixelId}&ev=PageView&noscript=1"/>
</noscript>
HTML;
    }
    
    /**
     * Tracker un événement personnalisé
     */
    public function trackEvent($category, $action, $label = '', $value = null) {
        $script = "gtag('event', '{$action}', {
            'event_category': '{$category}'";
        
        if ($label) {
            $script .= ", 'event_label': '{$label}'";
        }
        
        if ($value !== null) {
            $script .= ", 'value': {$value}";
        }
        
        $script .= "});";
        
        return "<script>{$script}</script>";
    }
    
    /**
     * Tracker une conversion e-commerce
     */
    public function trackPurchase($transactionId, $value, $currency = 'EUR', $items = []) {
        $itemsJson = json_encode($items);
        
        return <<<HTML
<script>
  // Google Analytics E-commerce
  gtag('event', 'purchase', {
    'transaction_id': '{$transactionId}',
    'value': {$value},
    'currency': '{$currency}',
    'items': {$itemsJson}
  });
  
  // Facebook Pixel Purchase
  fbq('track', 'Purchase', {
    value: {$value},
    currency: '{$currency}'
  });
</script>
HTML;
    }
    
    /**
     * Tracker un ajout au panier
     */
    public function trackAddToCart($productId, $productName, $value) {
        return <<<HTML
<script>
  // Google Analytics
  gtag('event', 'add_to_cart', {
    'items': [{
      'id': '{$productId}',
      'name': '{$productName}',
      'quantity': 1,
      'price': {$value}
    }]
  });
  
  // Facebook Pixel
  fbq('track', 'AddToCart', {
    content_ids: ['{$productId}'],
    content_name: '{$productName}',
    value: {$value},
    currency: 'EUR'
  });
</script>
HTML;
    }
    
    /**
     * Tracker une inscription
     */
    public function trackRegistration($method = 'email') {
        return <<<HTML
<script>
  gtag('event', 'sign_up', {'method': '{$method}'});
  fbq('track', 'CompleteRegistration');
</script>
HTML;
    }
    
    /**
     * Tracker un lead (formulaire de contact)
     */
    public function trackLead() {
        return <<<HTML
<script>
  gtag('event', 'generate_lead');
  fbq('track', 'Lead');
</script>
HTML;
    }
    
    /**
     * Obtenir tous les scripts analytics
     */
    public function getAllScripts() {
        return $this->getGoogleAnalyticsScript() . "\n" . $this->getFacebookPixelScript();
    }
}
