Entidades Generadas
========================

Entidades Generadas por Doctrine:mapping:import desde Mysql DB InnoDb
Relaciones y Campos de Tablas Generados Rudimetariamente.

Las Relaciones ORM no estan establecidas, hay que depurar y filtar las estidades
pero muchas estan ya establecidas para su uso.

Se pueden usar desde el bundle entidades o importarlas a otro bundle; preferible
usarlas desde el Bundle asi al modificar algo de este todos los involucrados
podran actualizar el bundle y las entidades que se modifiquen y estar al dia.

Entidades:
------------

   Las Entidades Fueron creadas por las especificaciones publicadas por Luis. Por
los requerimientos exigidos al sistema, que fueron entregados. Dichas entidades
puede sufrir y deberan ser cambiadas a las necesidades del sistema..  

   Prefijo Sys: Son entidades del tipo sistema Especificas para la aplicación
La entidad SysUsuario seria una Extension de FOSUSER baseuser  para generar el usuario
el desarrollador debe agregar o elimiar campos segun su desarrollo para lo que 
necesite.
   Prefijo Data: son Datos normalmente modificados por el usuarios común y propios
del mismo.
    Prefijo Adm: para las tablas con datos Administrativos y propios del administrador


NOTA:
--------
Al establecer una modificacion revisar el Git para asegurar la modificación  
cada entidad debe ser tratada por cada modulu que se vaya modificar, si es 
necesario otra modificacion a una entidad que pertenece a otro modulo hacer
publica la modificación y compartirla entre los desarrolladores para que sea 
posible obtener la actualización..
