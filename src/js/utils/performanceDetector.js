/**
 * Утилита для определения производительности устройства
 * и адаптации анимаций для слабых устройств
 */

class PerformanceDetector {
    constructor() {
        this.devicePerformance = 'high'; // 'low', 'medium', 'high'
        this.isMobile = false;
        this.isSlowDevice = false;
        
        this.detectDevice();
        this.detectPerformance();
    }
    
    /**
     * Определяем тип устройства
     */
    detectDevice() {
        const ua = navigator.userAgent;
        this.isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(ua);
        
        // Проверяем размер экрана
        const isSmallScreen = window.innerWidth <= 768;
        
        if (this.isMobile || isSmallScreen) {
            this.devicePerformance = 'medium';
        }
    }
    
    /**
     * Определяем производительность через тесты
     */
    detectPerformance() {
        // Проверка количества ядер процессора
        const cores = navigator.hardwareConcurrency || 2;
        
        // Проверка памяти (если доступно)
        const memory = navigator.deviceMemory || 4;
        
        // Проверка через Performance API
        const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
        const effectiveType = connection?.effectiveType || '4g';
        
        // Определяем уровень производительности
        if (cores <= 2 || memory <= 2 || effectiveType === '2g' || effectiveType === 'slow-2g') {
            this.devicePerformance = 'low';
            this.isSlowDevice = true;
        } else if (cores <= 4 || memory <= 4 || effectiveType === '3g') {
            this.devicePerformance = 'medium';
        } else {
            this.devicePerformance = 'high';
        }
        
        // Если мобильное устройство с низкой производительностью
        if (this.isMobile && this.devicePerformance === 'low') {
            this.isSlowDevice = true;
        }
        
        // Сохраняем в data-атрибут для CSS
        document.documentElement.setAttribute('data-performance', this.devicePerformance);
        
        if (this.isSlowDevice) {
            document.documentElement.classList.add('slow-device');
        }
    }
    
    /**
     * Получить конфигурацию анимаций в зависимости от производительности
     */
    getAnimationConfig() {
        const configs = {
            low: {
                transitionDuration: 200, // мс
                enableHoverEffects: false,
                enableParallax: false,
                reducedMotion: true
            },
            medium: {
                transitionDuration: 300,
                enableHoverEffects: true,
                enableParallax: false,
                reducedMotion: false
            },
            high: {
                transitionDuration: 400,
                enableHoverEffects: true,
                enableParallax: true,
                reducedMotion: false
            }
        };
        
        return configs[this.devicePerformance];
    }
    
    /**
     * Проверка, поддерживает ли устройство аппаратное ускорение
     */
    supportsHardwareAcceleration() {
        const canvas = document.createElement('canvas');
        const gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
        return !!gl;
    }
}

// Экспортируем singleton
const performanceDetector = new PerformanceDetector();
export default performanceDetector;

