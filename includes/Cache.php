<?php
class Cache {
    private $cache_path;
    private $cache_time = 3600; // 1 heure par défaut
    
    public function __construct($cache_time = 3600) {
        $this->cache_path = __DIR__ . '/../cache/';
        $this->cache_time = $cache_time;
        
        if (!is_dir($this->cache_path)) {
            mkdir($this->cache_path, 0777, true);
        }
    }
    
    public function set($key, $data) {
        $filename = $this->getFilename($key);
        $cache_data = [
            'time' => time(),
            'data' => $data
        ];
        
        return file_put_contents($filename, serialize($cache_data));
    }
    
    public function get($key) {
        $filename = $this->getFilename($key);
        
        if (!file_exists($filename)) {
            return false;
        }
        
        $cache_data = unserialize(file_get_contents($filename));
        
        if (time() - $cache_data['time'] > $this->cache_time) {
            unlink($filename);
            return false;
        }
        
        return $cache_data['data'];
    }
    
    public function delete($key) {
        $filename = $this->getFilename($key);
        if (file_exists($filename)) {
            return unlink($filename);
        }
        return false;
    }
    
    public function clear() {
        $files = glob($this->cache_path . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
    
    private function getFilename($key) {
        return $this->cache_path . md5($key) . '.cache';
    }
}
