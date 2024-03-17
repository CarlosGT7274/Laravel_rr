<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $estados = [
            'Aguascalientes',
            'Baja California',
            'Baja California Sur',
            'Campeche',
            'Chiapas',
            'Chihuahua',
            'Ciudad de México',
            'Coahuila',
            'Colima',
            'Durango',
            'Estado de México',
            'Guanajuato',
            'Guerrero',
            'Hidalgo',
            'Jalisco',
            'Michoacán',
            'Morelos',
            'Nayarit',
            'Nuevo León',
            'Oaxaca',
            'Puebla',
            'Querétaro',
            'Quintana Roo',
            'San Luis Potosí',
            'Sinaloa',
            'Sonora',
            'Tabasco',
            'Tamaulipas',
            'Tlaxcala',
            'Veracruz',
            'Yucatán',
            'Zacatecas',
        ];

        $this->app->instance('estados_mx', $estados);

        $estados_civiles = [
            'Soltero/a',
            'Casado/a',
            'Divorciado/a',
            'Separado/a en proceso judicial',
            'Viudo/a',
            'Concubinato',
        ];

        $this->app->instance('estados_civiles', $estados_civiles);

        $parentescos = [
            'Padre',
            'Madre',
            'Hermano',
            'Hermana',
            'Abuelo',
            'Abuela',
            'Esposo',
            'Esposa',
            'Hijo',
            'Hija',
            'Suegro',
            'Suegra',
            'Cuñado',
            'Cuñada',
            'Yerno',
            'Nuera',
            'Tío',
            'Tía',
            'Sobrino',
            'Sobrina',
        ];

        $this->app->instance('parentescos', $parentescos);

        $file_types = [
            'application/rtf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'text/csv',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/x-rar-compressed',
            'application/x-7z-compressed',
            'application/zip',
            'text/plain',
            'application/pdf',
            'application/xml',
            'application/json',
            'audio/mpeg',
            'audio/wav',
            'video/mp4',
            'video/x-msvideo',
            'video/webm',
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/bmp',
            'image/svg+xml',
            'image/webp',
        ];

        $this->app->instance('file_types', $file_types);
        
        $file_extensions = [
            'rtf',
            'doc',
            'docx',
            'csv',
            'xls',
            'xlsx',
            'ppt',
            'pptx',
            'rar',
            '7z',
            'zip',
            'txt',
            'pdf',
            'xml',
            'json',
            'mp3',
            'wav',
            'mp4',
            'avi',
            'webm',
            'jpg',
            'png',
            'gif',
            'bmp',
            'svg',
            'webp',
        ];

        $this->app->instance('file_extensions', $file_extensions);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
