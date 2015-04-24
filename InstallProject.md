# Instalación del proyecto
----------------------------------


Pasos...
----

1. Clonar el repositorio en [http://gitlab.greicodex.com/caracas/sunahip.git](http://gitlab.greicodex.com/caracas/sunahip.git)
2. Instalar vendors y bundles adicionales con composer update 
3. Despues de Instalar los Bundles y vendors Cargar los parametros para la Base de datos y configuración de correo
   
Editar el archivo "parameter.yml"
---------------------

        database_name: BASEDATOS
        database_user: USUARIO
        database_password: PASSWORD
        mailer_transport: TRANSPORTE_DE_CORREO -> Ejemplo gmail
        mailer_host: HOST_DE_CORREO -> si es gmail usar -> null
        mailer_user: USUARIO_DE_CORREO  -> si es Gmail usar el usuario solamente
        mailer_password: PASSOWORD



##Ejecutar los Comando de Consola

#####Para Ejecutar los comandos de consola se usa el comando:
     
    php app/console COMANDO 

* doctrine:database:create (Ejecutar una Sola Vez)
* doctrine:schema:create   (Ejecutar una Sola Vez)
* doctrine:fixtures:load   (Ejecutar una Sola Vez)
* assets:install
* assetic:dump
* fos:js-routing:dump
* cache:clear --env=prod


Todo listo para Ejecutar la aplicación, recordar hacer el enlace a la carpeta web para que el servidor virtual apunte a dicha carpeta.  