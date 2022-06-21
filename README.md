# Proyecto_Final-Almazara_aceite

INTRODUCCIÓN.

Este proyecto consistirá en el desarrollo de una aplicación web con la que se podría gestionar una pequeña almazara cooperativa de aceite con nombre:
ALMAZARA COOPERATIVA MOLINO DEL SUR





 La almazara estaría formada por un conjunto de socios que se unirían para moler su propia aceituna, elaborarían sus propias clases de aceite y lo venderían directamente desde la tienda online que se encontraría en la propia aplicación. 
En lo que respecta a la parte de cara al público de la aplicación, estarían los usuarios normales que son los que comprarían y consumirían este aceite.
 La aplicación constaría de varias interfaces principales, cuyo aspecto y funcionalidad dependerán del rol del usuario que esté activo en ese momento.
Esta aplicación está desarrollada en la web para que los usuarios puedan acceder a ella sin necesidad de instalar software en su equipo informático. El único requisito que necesitarían los usuarios sería el de disponer de un navegador web en cualquier dispositivo y una conexión a internet.
Al estar implementada de esta forma serviría para dar soporte tanto a usuarios normales que visiten la aplicación, como a socios o administradores que necesiten organizar el funcionamiento de la almazara.


OBJETIVOS.

El objetivo principal de la elaboración de esta aplicación web viene dado por la necesidad de grupos de agricultores que necesitan gestionar la producción de sus tierras dedicadas al olivo y quieren dar salida a su propio aceite al mercado. 
Creen que lo correcto es que haya un contacto directo entre la materia prima, el proceso de producción en el que estarían involucrados todos los socios que formarían la propia cooperativa y los usuarios de a pie que consumirían este bien tan preciado como es el aceite de oliva. 
Así se lograría unirlos un poco más y que el producto resultante fuera un producto lo más directo posible entre su lugar de origen y su consumo final, eliminando el máximo de intermediarios posibles.
También se lograría mantener a los proveedores o socios más unidos e informados en todo momento. Ya que, todas las consultas referentes al proceso de almacenamiento, cantidad de cosecha en cada una de sus parcelas, retirada de su propio producto, precio del aceite y venta del producto final serían inmediatas y se podrían revisar datos al instante.
Otro de los objetivos de la aplicación es que el administrador de la almazara, tuviera centralizados todos los datos de los socios, productos, clientes, cosechas o ventas. Con lo cual, sería más fácil llevar un seguimiento de todos los movimientos que se realizaran en la cooperativa.

REQUISITOS.

Tras investigar y hacer una recopilación de información sobre cómo funcionan estas almazaras cooperativas puedo proponer los siguientes requisitos para que la aplicación pueda llegar a ser funcional.
Deberían existir cuatro tipos de roles de usuario en los que cada uno llevaría a cabo funciones diferentes o en algunos casos parecidas.

	Anónimo: usuario que podrá acceder a la página principal de la aplicación. Dentro de la cual podrá conocer los servicios ofrecidos por la almazara, datos referentes a la misma y podrá disponer del servicio de tienda online. Con lo cual, podrá comprar productos sin ningún problema e imprimir su factura. Este usuario no necesita ningún tipo de registro y no necesita iniciar ninguna sesión, solo se le pedirían sus datos personales y dirección para la entrega del pedido realizado en la tienda. Sus datos se almacenarían en la BBDD como un usuario y a la vez como anónimo sin contraseña, para tener constancia de las ventas de la almazara.

	Cliente: este tipo de usuario podrá hacer lo mismo que el anónimo. Pero dentro del entorno de la tienda online podrá registrarse y sus datos servirán para que la próxima vez pueda iniciar sesión introduciendo únicamente su dirección de correo y una contraseña. Por lo tanto, cada vez que entre en la tienda puede iniciar sesión y automáticamente estarían disponibles los datos referentes a su dirección de entrega, dándole más facilidades para la compra. Se almacenaría en BBDD como un usuario y a la vez como cliente.

	Socio: este tipo de usuarios son los que hacen posible la almazara. Puesto que, son los proveedores de esta. Serían registrados por el administrador de la almazara. Ya que, no podrían hacerse socios solo accediendo a la página principal donde tienen acceso los usuarios anónimos y los clientes. A la hora de registrarse se les pedirían sus datos personales, dirección y la identificación de sus diferentes parcelas de cultivo para ver su extensión, que tipo de cultivo realizan, cuantas plantas de olivo tendría o qué clase de aceituna cultivan entre otros. (Apartado en desarrollo) Estos podrían consultar en cualquier momento todas las estadísticas relativas a la producción en cualquiera de sus parcelas como, el rendimiento de la aceituna, la cantidad de producción en kg o litros, el tipo de acidez que tendría cada una de sus entradas de producto. Tanto sus datos como los de las parcelas se almacenarían en BBDD.

	Administrador: este usuario es también un socio y el encargado del mantenimiento principal de la aplicación, el presidente de la cooperativa. Gestiona a los socios, a los clientes, a la producción, las parcelas, a los productos y a la tienda de la aplicación. Al ser un socio más de la almazara podría dejar el puesto en un plazo acordado entre los integrantes de la cooperativa. Tendría el privilegio de modificar o eliminar a los diferentes socios y a sus parcelas.







Para que este tipo de roles puedan interactuar necesitaríamos que la interfaz de la aplicación se dividiera en varias partes para cada uno de ellos:
	Una página inicial donde el usuario anónimo y el cliente tendrían la posibilidad de navegar por diferentes apartados, como serían:

•	“Inicio”. La primera página que verían los usuarios que accedieran a la aplicación de la zona pública. Daría unas primeras impresiones sobre la almazara y sobre cómo es el trabajo de la recogida de la aceituna.

•	“Quienes somos”. Dónde se explicaría como se formó la almazara, quién la compondría y algunos aspectos más importantes sobre la estructura y visión de futuro de la propia almazara cooperativa.

•	“Actualidad”. Apartado reservado para las noticias más importantes referentes a la almazara y al sector del aceite de oliva.

•	“Contacto”. Apartado donde podría verse mediante un mapa de Google maps la situación de la almazara. También estarían disponibles los teléfonos de contacto y los correos electrónicos para que cualquier usuario pudiera ponerse en contacto con los representantes de la almazara.

•	“Tienda”. Uno de los puntos fuertes de la aplicación. Dónde se ofrecerían los diferentes aceites de los que dispone la almazara y donde su venta estaría disponible para todo el público. Pudiendo elegir cualquier producto y la cantidad deseada. Así como revisar los productos elegidos dentro del carrito de la compra para su posterior y definitiva compra.

Dentro del entorno de la tienda estaría la posibilidad de registrarse o iniciar sesión por parte del usuario. Pasaría así de ser un usuario anónimo a un cliente de la tienda de la almazara.

Dentro de este mismo apartado, el cliente que ya estuviera registrado podría iniciar sesión introduciendo sus credenciales. Así, tendría la posibilidad de realizar sus compras más ágilmente utilizando ya sus datos ingresados con anterioridad y en cualquier momento podría cerrar sesión para eliminar sus datos del navegador.





•	“Acceso socios”. En este apartado ya entrarían en acción la otra parte de los roles de la aplicación, los socios y el administrador. Al entrar en esta zona habría la posibilidad de que el socio iniciara sesión con su dni y la contraseña que se le hubiera asignado a la hora de su registro. 

A partir de aquí ya se redireccionaría al socio a la zona que tuviera asignada. A la zona de los socios o a la zona de administración.
En la zona de socios estos podrían: (Apartado en desarrollo)
	Ver sus parcelas registradas.
	Ver la producción según fechas y parcelas.
	Consultar el rendimiento o acidez de las entradas de producto.
	Modificar alguno de sus datos personales.
	Ver el precio del aceite en el panorama actual.
	Ver las ferias dónde asistirá la almazara.
	Cerrar la sesión.

En lo que respecta a la zona del administrador, también podría hacer una serie de acciones:
	Gestión de todo lo relacionado con los socios, clientes, parcelas, productos y producciones. Se harían las funciones básicas o C.R.U.D
	Revisar información referente a las ventas de la tienda.
	Cerrar sesión.

Otro de los requisitos necesarios para la aplicación, sería que la página fuera amigable e intuitiva. Que con solo echar un par de vistazos supieras en todo momento que quieres ver y lo que quieres hacer. 
También que en todo momento sepas dónde estás situado dentro de la página para que sea fácil reconocer los pasos que llevas dados.

Los colores de la página deberían ser en tonos verdes, amarillos y blancos ya que se está intentado representar el aceite de oliva, el sol y la naturaleza como se representa en el logo de la cooperativa. De esta forma, se le daría al usuario una sensación de confort consiguiendo que la navegación por la aplicación web fuera de su agrado. Además, se intercalarían tonos negros que darían seguridad al formato de la página.

Por otra parte, las secciones de los socios y del administrador serían algo diferentes, menos estilizadas, ya que ellos realizarían otras acciones y funciones. Aunque se mantendría la forma intuitiva de navegar con facilidad por todos los apartados.

A continuación, pasamos a ver los casos de uso, el modelo de dominio y el modelo entidad relación de la aplicación:

GUIÓN DEL PROYECTO

1.	Estudio del problema y análisis del sistema

a)	Introducción

i.	Descripción del proyecto

Este proyecto consistirá en el desarrollo de una aplicación web con la que se podría gestionar una pequeña almazara cooperativa de aceite con nombre Molino del Sur.
La almazara estaría formada por un conjunto de socios que se unirían para moler su propia aceituna y así, apartarse de grandes intermediarios que encarecerían el producto. Elaborarían sus propias clases de aceite y lo venderían directamente desde la tienda online que se encontraría en la propia aplicación. 
La aplicación estaría dirigida sobre todo para productores pequeños de zonas agrícolas. De esta forma se les daría más amplia visión hacia el mercado global a través de internet haciéndolos un poco más dueños de su producto y de las ganancias generadas con él.
La aplicación constaría de varias interfaces principales, cuyo aspecto y funcionalidad dependerán del rol del usuario que esté activo en ese momento. Haciéndola más amigable para los clientes online para que a la hora de comprar, la transacción sea placentera.
Esta aplicación está desarrollada en la web para que los usuarios puedan acceder a ella sin necesidad de instalar software en su equipo informático. El único requisito que necesitarían los usuarios sería el de disponer de un navegador web en cualquier dispositivo y una conexión a internet.
Al estar implementada de esta forma serviría para dar soporte tanto a usuarios normales que visiten la aplicación, como a socios o administradores que necesiten organizar el funcionamiento de la almazara.

b)	Funciones y rendimientos deseados

i.	Qué queremos conseguir con el sistema a implementar.

El objetivo principal de la elaboración de esta aplicación web viene dado por la necesidad de grupos de agricultores que necesitan gestionar la producción de sus tierras dedicadas al olivo y quieren dar salida a su propio aceite al mercado teniendo un poco más de control sobre su producción y beneficios. 
Creemos que lo correcto es que haya un contacto directo entre la materia prima, el proceso de producción en el que estarían involucrados todos los socios que formarían la propia cooperativa y los usuarios de a pie que consumirían este bien tan preciado como es el aceite de oliva. 
Así se lograríamos unirlos un poco más y que el producto resultante fuera un producto lo más directo posible entre su lugar de origen y su consumo final, eliminando el máximo de intermediarios posibles.
También lograríamos mantener a los proveedores o socios más unidos e informados en todo momento. Ya que, todas las consultas referentes al proceso de almacenamiento, cantidad de cosecha en cada una de sus parcelas, retirada de su propio producto, precio del aceite y venta del producto final serían inmediatas y se podrían revisar datos al instante.
Otro de los objetivos de la aplicación es que el administrador de la almazara, tuviera centralizados todos los datos de los socios, productos, clientes, cosechas o ventas. Con lo cual, sería más fácil llevar un seguimiento de todos los movimientos que se realizaran en la cooperativa.
En definitiva, lo que se querría conseguir con esta aplicación es que el cultivo del olivar fuera más accesible para el usuario de a pie. Con lo cual el agricultor podría beneficiarse mucho más de su trabajo y así verían recompensados de una forma más eficaz sus esfuerzos.




c)	Objetivos

i.	Qué servicios ofrecerá el sistema una vez implementado.

Los servicios que ofrecerá nuestra aplicación una vez esté implementada, podrían considerarse dos a grandes rasgos que estarían diseminados en otros más pequeños.
Un primer servicio enfocado al usuario que navega por internet y que es nuestro gran nicho de mercado al implementar esta aplicación. Se le daría toda la información necesaria para que estuviera informado de como es la almazara, como se trabaja en ella, las noticias más relevantes relacionadas con este tipo de cultivo, todos los medios de contacto de los que dispondría la almazara teléfonos, email o dirección entre otros.
Para conseguir todo esto, la página web constaría de los siguientes apartados o secciones:

•	“Inicio”. La primera página que verían los usuarios que accedieran a la aplicación de la zona pública. Daría unas primeras impresiones sobre la almazara y sobre cómo es el trabajo de la recogida de la aceituna.

•	“Quienes somos”. Dónde se explicaría como se formó la almazara, quién la compondría y algunos aspectos más importantes sobre la estructura y visión de futuro de la propia almazara cooperativa.

•	“Actualidad”. Apartado reservado para las noticias más importantes referentes a la almazara y al sector del aceite de oliva.

•	“Contacto”. Apartado donde podría verse mediante un mapa de Google maps la situación de la almazara. También estarían disponibles los teléfonos de contacto y los correos electrónicos para que cualquier usuario pudiera ponerse en contacto con los representantes de la almazara.





•	“Tienda”. Uno de los puntos fuertes de la aplicación. Dónde se ofrecerían los diferentes aceites de los que dispone la almazara y donde su venta estaría disponible para todo el público. Pudiendo elegir cualquier producto y la cantidad deseada. Así como revisar los productos elegidos dentro del carrito de la compra para su posterior y definitiva compra.

Dentro del entorno de la tienda estaría la posibilidad de registrarse o iniciar sesión por parte del usuario. Pasaría así de ser un tipo de usuario más anónimo a ser un cliente de la tienda para próximas visitas.

Dentro de este mismo apartado, el cliente que ya estuviera registrado podría iniciar sesión introduciendo sus credenciales. Así, tendría la posibilidad de realizar sus compras más ágilmente utilizando ya sus datos ingresados con anterioridad y en cualquier momento podría cerrar sesión para eliminar sus datos del navegador.

El otro servicio más representativo que ofrecería nuestra aplicación sería el de administración enfocado a los propios agricultores. Y que sería accesible también por la página web mediante la sección de acceso socios:

•	“Acceso socios”. En este apartado ya entrarían en acción la otra parte de los roles de la aplicación, los socios y el administrador. Al entrar en esta zona habría la posibilidad de que el socio iniciara sesión con su dni y la contraseña que se le hubiera asignado a la hora de su registro. 

En lo que respecta a la zona del administrador, que sería la más importante, podría hacer una serie de acciones:
	Gestión de todo lo relacionado con los socios, clientes, parcelas, productos y producciones. Se harían las funciones básicas o C.R.U.D
	Revisar información referente a las ventas de la tienda.
	Cerrar sesión.

De esta misma forma todos estos datos almacenados y configurados serían accesibles mediante varias formas de consultas que serían de gran ayuda para la toma de decisiones.





Por lo que se refiere a la zona del socio, también podría realizar algunas acciones algo más livianas (Apartado en desarrollo).
	Ver sus parcelas registradas.
	Ver la producción según fechas y parcelas.
	Consultar el rendimiento o acidez de las entradas de producto.
	Modificar alguno de sus datos personales.
	Ver el precio del aceite en el panorama actual.
	Ver las ferias dónde asistirá la almazara.
	Cerrar la sesión.
Después de analizar los servicios que se ofrecerá la aplicación vamos a estudiar los diferentes usuarios y como actuarán para que estos servicios sean aprovechados
Tras investigar y hacer una recopilación de información sobre cómo funcionan estas almazaras cooperativas puedo proponer los siguientes requisitos para que la aplicación pueda llegar a ser funcional.
Deberían existir cuatro tipos de roles de usuario en los que cada uno llevaría a cabo funciones diferentes o en algunos casos parecidas.

	Anónimo: usuario que podrá acceder a la página principal de la aplicación. Dentro de la cual podrá conocer los servicios ofrecidos por la almazara, datos referentes a la misma y podrá disponer del servicio de tienda online. Con lo cual, podrá comprar productos sin ningún problema e imprimir su factura. Este usuario no necesita ningún tipo de registro y no necesita iniciar ninguna sesión, solo se le pedirían sus datos personales y dirección para la entrega del pedido realizado en la tienda. Sus datos se almacenarían en la BBDD como un usuario y a la vez como anónimo sin contraseña, para tener constancia de las ventas de la almazara.

	Cliente: este tipo de usuario podrá hacer lo mismo que el anónimo. Pero dentro del entorno de la tienda online podrá registrarse y sus datos servirán para que la próxima vez pueda iniciar sesión introduciendo únicamente su dirección de correo y una contraseña. Por lo tanto, cada vez que entre en la tienda puede iniciar sesión y automáticamente estarían disponibles los datos referentes a su dirección de entrega, dándole más facilidades para la compra. Se almacenaría en BBDD como un usuario y a la vez como cliente.

	Socio: este tipo de usuarios son los que hacen posible la almazara. Puesto que, son los proveedores de esta. Serían registrados por el administrador de la almazara. Ya que, no podrían hacerse socios solo accediendo a la página principal donde tienen acceso los usuarios anónimos y los clientes. A la hora de registrarse se les pedirían sus datos personales, dirección y la identificación de sus diferentes parcelas de cultivo para ver su extensión, que tipo de cultivo realizan, cuantas plantas de olivo tendría o qué clase de aceituna cultivan entre otros. (Apartado en desarrollo) Estos podrían consultar en cualquier momento todas las estadísticas relativas a la producción en cualquiera de sus parcelas como, el rendimiento de la aceituna, la cantidad de producción en kg o litros, el tipo de acidez que tendría cada una de sus entradas de producto. Tanto sus datos como los de las parcelas se almacenarían en BBDD.

	Administrador: este usuario es también un socio y el encargado del mantenimiento principal de la aplicación, el presidente de la cooperativa. Gestiona a los socios, a los clientes, a la producción, las parcelas, a los productos y a la tienda de la aplicación. Al ser un socio más de la almazara podría dejar el puesto en un plazo acordado entre los integrantes de la cooperativa. Tendría el privilegio de modificar o eliminar a los diferentes socios y a sus parcelas.

d)	Planteamiento, evaluación de diversas soluciones y justificación de la solución elegida.

El planteamiento que me llevó a elegir esta solución fue pensar en la inconformidad de algunos pequeños agricultores del mundo del olivar por el gasto extra de transportar la cosecha a cooperativas grandes que mezclan todos sus aceites con los de las diferentes sedes que tienen repartida por el panorama. 
También me generaba inquietud el ver como el aceite generado por la aceituna tan bien tratada durante todo el año era exportado a diferentes países y a nosotros se nos vende el aceite de otros países siendo el nuestro uno de los mejores del mundo.
Lo que persigo con está aplicación es evitar todos estos escollos y que cada agricultor y la gente que consume este aceite, consuma un producto de cercanía, un producto que sabemos de donde procede y como se ha tratado. Ya que, los aceites de otros puntos del planeta son tratados de manera diferente.
Por lo tanto, quise hacer una aplicación con la que se pudiera administrar diferentes personas dispuestas a formar una cooperativa. Que tuvieran en común sus tierras y por lo tanto su fruto y a la misma vez que este producto pudiera venderse de forma fácil y directa al consumidor online que a día de hoy sigue creciendo exponencialmente.
Es una aplicación enfocada a las pequeñas cooperativas locales que logra ayudar a estos agricultores a dar salida a su producto de forma más fácil y eficaz viendo el fruto de su trabajo.

Esta fue la manera más eficaz que vi para dar solución a varios de estos problemas. Una página web que a día de hoy son necesarias, que pudiera ayudar a agricultores no tan ligados al mundo web a que pudieran vender su producto de forma eficaz.


e)	Modelado de la solución.

i.	Recursos humanos.

Este proyecto va a ser realizado exclusivamente por mi persona. Nadie más intervendrá en su desarrollo. Pediré alguna información a personas relacionadas con el tema o instituciones, pero el desarrollo de este dependerá exclusivamente de mí.
 El trabajo se ha ido distribuyendo según la disponibilidad de tiempo que he podido tener.
En los primeros veinte días se especificó el problema, se dio forma a la BBDD que almacenaría todo el sistema y se aclararon dudas con los profesores.
En los siguientes quince días se diseño el aspecto que tendría la página web de cara al público, los colores, logo o formas entre otras elecciones
A partir de este punto se fue desarrollando la aplicación, primero dando forma a la zona de administración para poder disponer de socios y así, de sus parcelas y producciones y por lo tanto del aceite que se venderá. A continuación, se diseñó la zona de cara al público y la zona de la tienda para que el usuario online tuviera todas las facilidades para la compra.
De forma paralela a estas acciones se fue tratando la documentación.
Todas las acciones han sido revisadas cada catorce días por los profesores para darnos consejos sobre las implementaciones de funciones.
ii.	Recursos hardware

Para la realización de este proyecto he utilizado exclusivamente mi ordenador portátil marca Acer Aspire A715-75G que tiene un procesador Intel Core i5-10300H CPU con una velocidad de 2.50 GHz y 8GB de memoria RAM.
Con sus características me ha sido completamente funcional, ha cumplido con creces su cometido y ha sido suficiente para poder realizar mi trabajo sin ningún tipo de problema.



iii.	Recursos software.

En lo que se refiere al software he utilizado el que normalmente utilizo en mis estudios y trabajo. Es con el que me siento más cómodo y lo describo a continuación:

	Como sistema operativo Windows 10 Pro.
	En entorno de desarrollo que he utilizado ha sido PhpStorm, que es el que hemos utilizado durante todo el curso y estoy más familiarizado con él. Y como editor de código alternativo, Visual Studio Code ya que su uso está muy extendió y tiene mucho soporte de la comunidad.
	Para la gestión de BBDD, el servidor web Apache y el intérprete de lenguaje de script PHP utilizo XAMPP, que es un paquete de software libre.
	En lo referente a ofimática: Microsoft Office mediante Word o Excel entre otros para editar texto o definir los plazos del proyecto.
	Ofimática online, Google Drive.
	Bloc de notas para tomar apuntes.
	El capturador de pantalla para ayudarme con las diferentes imágenes que he utilizado en el desarrollo del proyecto
	Como navegadores web utilizo Google Chrome y Microsoft Edge.
	Correo electrónico en línea con Gmail u Outlook.
	Editor de imágenes como GIMP o Paint 3D.
	Mapas con Google Maps.















f)	Planificación temporal revisable.

Para la planificación del proyecto me he ayudado del diagrama de Gantt, una de las opciones que nos propone le profesorado. He adaptado los tiempos de trabajo ya que el tiempo que hemos tenido para el proyecto ha sido más o menos de dos meses y medio, 75 días. Pues el diagrama lo he puesto como 10 días por mes y 5 por el medio mes de junio, 25 días. Para así, adaptar más o menos los días.

![Planificación de proyecto](https://user-images.githubusercontent.com/99965831/174848835-22bed83a-df19-4de6-8029-f6be7b5887d8.PNG)

2.	Ejecución del proyecto

a)	Elaboración de la documentación técnica.

i.	Casos de uso 

![Casos de uso](https://user-images.githubusercontent.com/99965831/174849041-8a558fc1-dbd2-4d56-914c-fb32dab92860.png)

ii.	Modelo E/R

![Modelo E-R](https://user-images.githubusercontent.com/99965831/174849118-a2da741b-2841-47e3-8a51-1f60ff46091d.PNG)

iii.	Modelo de dominio

![Modelo de dominio](https://user-images.githubusercontent.com/99965831/174849196-fbfce335-b012-45a5-8509-026e214ca7db.PNG)

4.	Documentación del sistema

a)	Introducción a la aplicación.

La aplicación web Molino del Sur, sería una aplicación simple, dinámica e intuitiva para que el usuario pudiera utilizarla de forma rápida y eficaz. 

	Visibilidad del estado del sistema
La aplicación indicaría en todo momento al usuario donde se encuentra. Al pasar de páginas indicaría mediante un texto con enlace por las páginas que ha pasado, para que en cualquier momento pueda volver atrás.

	Lenguaje simple
El lenguaje utilizado en la página y los mensajes de información sería fácil e intuitivo para que todos los usuarios pudieran entenderlo.

	Flexibilidad
La aplicación se adapta a todos los perfiles de usuario ya que tendría acciones y elementos fáciles de manipular.



	Servicio al cliente
El servicio de atención al cliente es uno de los elementos principales que toda app debe tener ya que si en algún momento un usuario tiene un problema deberíamos solucionárselo sin demora. Tenemos a su disposición números de teléfono y direcciones del correo electrónico.

	Contacto con el olivar
Queremos transmitir en todo momento cercanía y transparencia con el usuario para que nos vea como alguien cercano y no tengan ningún impedimento en utilizar nuestros servicios.

En definitiva, he querido que la aplicación sea en elemento más dentro de la vida de los usuarios y que cuando necesiten un buen aceite de oliva, acudan a nuestra página pensando en la calidad del producto que ofrecemos y el trabajo cercano de los socios que conforman esta sociedad.
De la misma forma he querido que al administrador le resulte muy accesible la forma de controlar todos los datos referentes a los socios y sus parcelas. Así como los datos referentes a la tienda y a los productos de esta.

b)	Manual de Instalación. 

Para poder ejecutar la aplicación web Molino del Sur, no habría que realizar ninguna instalación complementaria. 
Como es una aplicación en la nube, con solo un navegador y conexión a internet podríamos conectarnos a ella.
En un principio entre los navegadores que se han probado y soportan la aplicación se encontrarían Google Chrome, Microsoft Edge y Opera. En dispositivos de sobremesa y portátil.
En dispositivos móviles solo se han probado algunas funciones y no sería recomendable lanzar la aplicación ya que no obtendríamos todo su potencial.
Por lo tanto, se recomienda lanzarla en dispositivos de sobremesa y portátil con los navegadores mencionados anteriormente.

c)	Manual de usuario. 

En esta parte detallaremos el manual para que el usuario cotidiano pueda usar la aplicación web Molino del Sur sin ningún problema





	Inicio

Para acceder a la aplicación es necesario disponer de acceso a Internet y, mediante el uso de un navegador (Chrome, Opera o Microsoft Edge) cargar la URL: http://molinodelsur.edu
Para poder acceder a esta aplicación no sería necesario estar registrado ni dado de alta. Se podría navegar libremente a través de sus secciones y comprar los diferentes productos solo ingresando los datos de envío.

	Navegación

En lo que respecta a la navegación a través de sus secciones tendríamos una barra de navegación muy fácil de utilizar.

En ella vemos los diferentes apartados por los que movernos. Las zonas de Inicio, Quienes somos, Actualidad y Contacto serían meramente informativas. Darían datos de la almazara, como situación, teléfonos, email, información de la línea de vida que lleva desarrollada y noticias del sector agrícola del olivar.























A continuación, ya al situarnos sobre la pestaña de la tienda, que sería la zona más importante de la zona de navegación vemos un icono de usuario para poder iniciar sesión o registrarnos y una pequeña cesta de la compra con los elementos que habríamos seleccionado para su posterior compra y desde donde podríamos dirigirnos al carrito de la compra para finalizarla.



Un poco más abajo ya veríamos los diferentes productos de los que dispone la almazara. En estos momentos dispondría de AVOE y AOV solamente, en un futuro se crearían alimentos que estuvieran hechos con aceite de oliva.











Para añadir productos al carrito solo habría que pulsar sobre cualquier objeto en el botón de añadir al carrito. Posteriormente dentro del carrito y en la página del carrito de la compra habría la posibilidad de aumentar las cantidades del producto.


 

Dentro del carrito pequeño superior veremos la siguiente imagen y que al pasar sobre la cantidad del producto nos dará la opción de cambiar esta. También podremos eliminar un producto pulsando el icono de la papelera que aparece al lado del precio.
 
Al modificar las cantidades los precios del carrito se actualizarán automáticamente, así como el número de productos que contiene.
El carrito se puede llenar sin estar registrado y posteriormente pasar a la página del carrito de la compra para finalizar esta.


Esta sería la página del carrito de la compra donde las cantidades de los productos podrían modificarse de igual forma que en la otra parte del carrito superior y los precios y cantidades se actualizarían automáticamente. 
Ya en la parte derecha aparecería el resultado final de la compra con el subtotal, un envío si el pedido es superior a 100€ y el total final a pagar.
Cuando pulsemos sobre finalizar la compra, si no hay nadie registrado (si hubiera alguien registrado en ese momento aparece el nombre en la parte superior de la ventana al lado de los menús) nos aparecería una ventana de inicio de sesión, para iniciar sesión si estamos registrados o tendríamos la opción de registrarnos como un cliente nuevo y luego iniciar sesión o podríamos insertar solo los datos necesarios para hacer la compra y se realizaría el envío sin registrarnos.
En este caso nos hemos registrado como un usuario anónimo ya que no hemos pulsado sobre el check que nos avisa para crear una cuenta. Si lo pulsamos nos ofrece introducir una contraseña para el registro, así como poner el nombre de nuestra empresa si la tuviéramos y ya con la contraseña podríamos iniciar sesión y ya tendríamos disponibles nuestros datos sin tener que volver a registrarnos cada vez.

En este caso solo hemos introducido los datos de envío.
 

Ya solo quedaría pulsar en finalizar compra para realizarla y seguidamente nos daría la opción de imprimir el albarán de entrega.
 
Se ha finalizado la compra y ahora veremos el pdf asociado al pulsar sobre el botón de descarga.
 
Como podemos apreciar salen todos los datos referentes a la compra y al usuario que la ha realizado, así como, la base imponible, el IVA, el envío y el precio final.
Al realizar la compra con este tipo de usuarios anónimos, justo cuando acaban de realizar la compra sus datos desaparecen del navegador y los de los productos que ha comprado.

Por otra parte, si iniciamos sesión, pulsando en el icono de usuario introduciremos nuestro email y la contraseña y si todo es correcto nos aparecerá el nombre de usuario en la parte superior de la página. Vamos a probar con un usuario anteriormente registrado.
 

 

De esta forma ya si mantendremos nuestra sesión iniciada hasta que decidamos cerrar sesión pulsando sobre el nombre y dando a la opción de cerrar sesión. A la misma vez los productos que seleccionemos se mantendrán en el carrito por unas 4 horas, aunque cerremos sesión, por di decidimos volver en cualquier momento y queremos ver que productos teníamos en nuestro carrito. Cabe mencionar que todo se almacena en las sesiones del navegador por lo tanto si cerramos el navegador se eliminarán todos los datos, para seguridad del usuario.
Otro elemento que cabe destacar es que cuando nos registremos como un cliente de la tienda. Nos llegará un mail para confirmar nuestra cuenta y con la contraseña que introdujimos anteriormente, para poder ingresar sin problemas ya que, si no se confirma, por defecto no se tendría acceso.

Por último, mencionar que el menú que aparece al final de la barra de navegación contiene un desplegable con información referente a nuestros contactos












d)	Manual de administración.

Ahora pasaremos a explicar la parte del panel del administrador y sus funcionalidades.
Para acceder al panel del administrador, dentro de la barra de navegación de la aplicación web, se encuentra el apartado acceso socios.
 

El cual al pulsarlo no aparecerá un formulario de login para introducir del dni del socio y una contraseña.

 

Una vez validados los datos pasaremos a la página del administrador que está dividida en varios apartados para el mantenimiento de la aplicación.


Como podemos observar el estilo de esta parte de la aplicación no es tan definido como la página web que se ofrece al público.
La barra de navegación ofrecería los apartados de Socios, Clientes, Parcelas, Producción, Tienda y Ventas, así como, un botón de cierre de sesión y en la parte superior el nombre del administrador su dni y la fecha actual.




Pasemos a ver cada sección:

	SOCIOS

En esta parte podemos ver a los socios registrados de la cooperativa. Estarían conformados en una tabla con paginación de 5 usuarios por página. A la izquierda podemos observar el formulario de registro de usuario donde introduciendo todos los datos necesarios pulsaremos en registrar y el nuevo usuario pasará a formar parte de la lista. Para actualizar la lista en cualquier momento solo bastaría con pulsar en los elementos de la paginación.


Como se observa en el mensaje de información, se le envía al socio un correo con la nueva contraseña que se le ha asignado para que la guarde para poder acceder a la aplicación.
 

Dentro de la tabla ya podríamos hacer algunas modificaciones, pasando el ratón por los campos nos informaría si son modificables, así como eliminar al usuario o activarlo o desactivarlo para que pueda o no acceder a la aplicación con lo cual podríamos dejarlo almacenado y le añadiríamos una fecha de baja para tener constancia.

	CLIENTES
En el apartado referente a los clientes podríamos ver los diferentes usuarios que han utilizado la aplicación web de cara al público, los usuarios que se han registrado o ha realizado alguna compra. De ellos tendríamos menos datos para consultar para así, preservar la integridad de los datos, en este apartado como en el de los socios también tendríamos la paginación pertinente. Aquí podríamos ver por ejemplo su email para contactar con ellos y el tipo de usuario que son “Cliente”, que se ha registrado en la aplicación, o “Anónimo” usuario que solamente ha comprado en la tienda sin registro alguno. 





	PARCELAS
Esta es una de las zonas más importante de la parte de administración ya que aquí registraríamos una parcela bajo el nombre de algún usuario ya registrado.


Aquí introduciríamos los datos necesarios como serían:
•	Por una búsqueda parcial al usuario que quisiéramos
•	A continuación, introducimos la Ref. Catastral de la parcela e inmediatamente se nos abriría una ventana directamente del catastro que, al pulsar sobre ella, obtendríamos los datos referentes a la susodicha parcela. Obteniendo así la provincia, el municipio, el polígono, la parcela y los metros cuadrados de la parcela, que serian introducidos por el administrador en sus inputs correspondientes.
•	A continuación, tenemos dos desplegables que nos proporcionarían sistemas de cultivo como secano-tradicional y variedades de aceituna a elegir como picual.
•	Por último, solo nos quedaría introducir el número de plantas de olivo que tendría nuestra parcela. 
El siguiente paso sería pulsar en registrar y la parcela ya se encontraría registrada bajo usuario elegido.


Una vez registradas las parcelas que deseemos podríamos hacer varias consultas pulsando en el botón de “Visualizar Datos” y se nos abriría un desplegable con todas las opciones disponibles. Al seleccionar alguna se nos mostraría una tabla con los datos resultantes. También podríamos modificar algunos de sus parámetros, poniendo el cursor sobre ellos nos lo indicaría. Y también podríamos eliminar cualquier parcela en concreto.



	PRODUCCIÓN
Otra de las partes esenciales de la aplicación puesto que, es aquí donde registraríamos las entradas de aceituna. Estas según el rendimiento obtenido y según la acidez de la aceituna clasificarían el aceite obtenido en AOVE o AOV, que serían los dos aceites que comercializaría nuestra aplicación.


Los datos a ingresar para poder insertar una remesa de producción serían:

•	Por búsqueda parcial elegiríamos al socio que trae la carga.
•	En el siguiente desplegable se nos mostrarían sus parcelas, de las cuales elegiríamos una.
•	Después elegiríamos el tipo de donde procede la aceituna “suelo” o ”vuelo”.
•	Introducimos los kilogramos de aceituna que trae el agricultor.
•	Ingresamos el rendimiento.
•	Ingresamos la acidez de la entrada.
Con estos datos, automáticamente se calcularían los litros de aceite obtenidos y se actualizarían los litros almacenados en la bodega para cada tipo de aceite, así como el tipo de aceite al que se correspondería la remesa, AOVE o AOV. 
Pulsaríamos en registrar y automáticamente se nos mostraría un ticket con los datos de la remesa y el usuario que la introduce. Aquí podríamos imprimir el ticket o cancelarlo.


Como en el apartado anterior también tendríamos un botón para visualizar datos. Se nos abriría un menú lateral y elegiríamos la consulta que más nos convenga.


	TIENDA

Esta zona es la referente a los productos que se mostraran en la tienda.
Aquí el administrador podrá crear productos en cualquier momento introduciendo una serie de datos, modificarlos o eliminarlos. Todos ellos estarán ligados a los litros de aceite que se almacenan en las bodegas de la aplicación y cada uno estará ligado a una categoría como con la comentadas anteriormente AOVE y AOV. 
En este apartado también se podrá ver el precio del aceite y modificarlo cuando este varíe. En la parte inferior de la página se nos mostrarán los litros que hay de cada tipo de aceite y pulsando el botón de actualizar que se encuentra al lado podremos actualizarlos en cualquier momento. Por si estamos en la aplicación y mientras hay usuarios comprando aceite.

Para registrar un producto debemos introducir:

	Una descripción del producto.
	Seleccionar una categoría AOVE o AOV.
	Indicar de cuantos recipientes estaría compuesto el lote.
	Cuantos litros de aceite contendría cada recipiente.
	Seleccionar una imagen para hacer el producto más atractivo al usuario
	Introducir un descuento si se desea.






	VENTAS

La última sección del apartado del administrador sería la zona reservada de las ventas realizadas.  En este apartado podríamos ver una tabla con los datos de las ventas realizadas en la aplicación web. El nombre del cliente así, como sus apellidos o email, y los distintos productos que ha comprado. También saldrían reflejadas las unidades vendidas   cuanto valdría cada una y el total de la venta, por último, podríamos ver la fecha en la que se realizó la venta.



Con este último apartado ya hemos visto la zona del administrador y todas las acciones que podría realizar para que el funcionamiento de la almazara fuera el correcto.










5.	Conclusiones finales.

a)	Grado de cumplimiento de los objetivos fijados

Una vez finalizado el proyecto y dispuesto para su presentación al profesorado hago un balance de lo objetivos fijados.

Desde mi punto de vista en gran medida, lo que me propuse lo he conseguido. Crear una zona de administración para socios con sus parcelas y que pudieran introducir sus producciones de aceite. 
De esta forma el aceite podría convertirse en productos que podrían venderse mediante la aplicación web.
Otro gran objetivo era crear una tienda más perfeccionada que las que hemos realizado en clase. Con lo cual también he conseguido crear una BBDD de usuarios que compran el aceite en la tienda y diferenciándolos entre usuarios registrados y clientes. 
También he conseguido utilizar los servicios de envío de correo en PHP y la muestra de documentos PDF a través de código HTML. Así como el servicio nusoap haciendo peticiones al catastro y que facilitan mucho los trámites de registro.
Ha sido un trabajo muy duro ya que había que compaginar las prácticas de trabajo del módulo con el proyecto integrado y en mi caso soy padre de familia y hay que añadir un plus más de dificultad. 
Me ha costado mucho trabajo llegar hasta donde he llegado, pero creo que he cumplido con las expectativas.










b)	Propuesta de modificaciones o ampliaciones futuras del sistema implementado.

Algunas de las modificaciones que debería implementar y que por falta de tiempo no he podido llegar a crear es la zona relativa a los socios de la cooperativa. En un principio era otra meta más del proyecto, pero ya el tiempo no me daba para más. 

Al comenzar también investigué por distintas aplicaciones parecidas y la zona de los socios no tenía la gran importancia, era una zona muy liviana. Yo quería darle al socio total control sobre los datos de sus parcelas y remesas de producción, pero ya era un trabajo extra imposible de realizar.

Otra implementación que tuve en cuenta al empezar fue la de una zona de creación de eventos y noticias por parte del administrador para tener informado en todo momento al socio de las ferias que ser podrían realizar y las noticias para actualizar la página principal para informar a la gente interesada en este sector.

Además de estas modificaciones más amplias también tenía en mente cambiar algunas cosillas de menor envergadura y que harían mejorar la aplicación

Ya eran modificaciones muy ambiciosas que en el tiempo del que disponíamos era imposible. Pero, estoy contento con lo realizado.



6.	Bibliografía.

Para ayudarme en la creación del proyecto me he apoyado en distintas aplicaciones web de la misma orientación que la mía:

https://almazarasdelasubbetica.com
https://www.almazara.net
https://tienda.oleocano.com
https://olibe.es
https://www.cooperativalacarrera.com	
He investigado en la página del ministerio de agricultura, pesca y alimentación
https://www.mapa.gob.es/es/
En el servicio del ministerio de la junta de Andalucía de agricultura
https://www.juntadeandalucia.es/organismos/agriculturaganaderiapescaydesarrollosostenible/servicios.html
He indagado y utilizado el catastro español para comprobar referencias catastrales.
Consulta de diferentes páginas de internet para la resolución de algunos problemas relacionados con el código como:
https://es.stackoverflow.com/
https://www.baulphp.com/
entre otras.
También como mi familia está relacionada con el campo, me he podido registrar en la cooperativa que tenemos y he podio investigar un poco más sobre como funciona y que pueden hacer los socios dentro de la aplicación de la que disponen, la cooperativa es:
https://dcoop.es/
He podido consultar y ver diferentes proyectos de alumnos de otros institutos para guiarme en algunos momentos que estaba perdido y ver cómo iban desarrollando los suyos propios. 
Me he apoyado en varias fuentes, que a veces me han ayudado mucho y he podido encontrar la luz que me ha ayudado a continuar en momentos en los que me atascaba. Ha sido un camino duro, pero creo que la recompensa al esfuerzo es mucho mayor.


