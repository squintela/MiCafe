CREATE SCHEMA micafe DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci ;
use micafe;

create table usuario (
  id int not null AUTO_INCREMENT,
  username varchar(15) not null,
  password varchar(15) not null,
  email varchar(30) not null,
  primary key(id),
	unique key (username)
);

create table empleado (
  id int not null AUTO_INCREMENT,
  nombres varchar(100) not null,
  apellidos varchar(100) not null,
  ci varchar(30) not null,
  genero char not null,
  cargo varchar(50) not null,
  telefono varchar(30) not null,
  id_usuario int not null,
  primary key(id),
	unique key(ci),
	unique key(id_usuario),
  foreign key(id_usuario) references usuario(id)
  on delete cascade on update cascade
);

create table producto (
  id int not null AUTO_INCREMENT,
  codigo varchar(16) not null,
  nombre varchar(50) not null,
  marca varchar(50) not null,
  unidad varchar(30) not null,
  tipo varchar(30) not null,
  precio float not null,
  volumen float not null,
  primary key(id),
	unique key(nombre, marca)
);

create table entrada (
  id int not null AUTO_INCREMENT,
  codigo varchar(16) not null,
  fecha datetime not null,  
  id_empleado int not null,
  primary key(id),
	unique key(codigo),
  foreign key(id_empleado) references empleado(id)
  on delete cascade on update cascade
);

create table salida (
  id int not null AUTO_INCREMENT,
  codigo varchar(16) not null,
  fecha datetime not null,  
  id_empleado int not null,
  primary key(id),
	unique key(codigo),
  foreign key(id_empleado) references empleado(id)
  on delete cascade on update cascade
);

create table entrada_producto (
  id int not null AUTO_INCREMENT,
  cantidad int not null,
  observacion varchar(50),
  id_entrada int not null,
  id_producto int not null,
  primary key(id),
	unique key(id_entrada,id_producto),
  foreign key(id_entrada) references entrada(id)
  on delete cascade on update cascade,
  foreign key(id_producto) references producto(id)
  on delete cascade on update cascade
);

create table salida_producto (
  id int not null AUTO_INCREMENT,
  cantidad int not null,
  observacion varchar(50),
  id_salida int not null,
  id_producto int not null,
  primary key(id),
	unique key(id_salida,id_producto),
  foreign key(id_salida) references salida(id)
  on delete cascade on update cascade,
  foreign key(id_producto) references producto(id)
  on delete cascade on update cascade
);

create table stock (
	id int not null AUTO_INCREMENT,
  id_producto int not null,  
  entradas int unsigned not null,
  salidas int unsigned not null,
  existencias int unsigned not null,  
  primary key(id),
  unique key(id_producto),
  foreign key(id_producto) references producto(id)
  on delete cascade on update cascade
);

CREATE TRIGGER ins_producto_stock after insert
ON producto
FOR each row
    insert into stock (id_producto, existencias, entradas, salidas) 
    value(NEW.id, 0,0,0);
    
CREATE TRIGGER ins_entrada_stock after insert
ON entrada_producto
FOR each row
	update stock set stock.entradas = stock.entradas + new.cantidad ,
    stock.existencias = stock.existencias + new.cantidad    
    where stock.id_producto = new.id_producto;    
    
CREATE TRIGGER ins_salida_stock after insert
ON salida_producto
FOR each row
	update stock set stock.salidas = stock.salidas + new.cantidad , 
	stock.existencias = stock.existencias - new.cantidad	
	where stock.id_producto = new.id_producto;
	
	
create table cliente (
  id int not null AUTO_INCREMENT,
  nombres varchar(100) not null,
  apellidos varchar(100) not null,
  celular varchar(30) not null,
  nit varchar(30) not null,
  primary key(id),
	unique key(nit)	
);

create table pedido (
  id int not null AUTO_INCREMENT,
  codigo varchar(16) not null,
  fecha datetime not null,
  monto float not null,
	tipo_pago varchar(50) not null,
	estado varchar(30) not null,
  id_empleado int not null,
  id_cliente int not null,
  primary key(id),
	unique key(codigo),
  foreign key(id_cliente) references cliente(id)
  on delete cascade on update cascade,
  foreign key(id_empleado) references empleado(id)
  on delete cascade on update cascade
);

create table factura (
	id int not null AUTO_INCREMENT,
	codigo varchar(16) not null,
	nit varchar(30) not null,
	fecha datetime not null,
	monto float not null,
	razon varchar(100) not null,
	cliente varchar(150) not null,
	id_pedido int not null,
	primary key(id),
	unique key(id_pedido),
	foreign key(id_pedido) references pedido(id)
  on delete cascade on update cascade
);

create table orden (
  id int not null AUTO_INCREMENT,
  cantidad int not null,
  precio float not null,
  id_producto int not null,
  id_pedido int not null,
  primary key(id),
  foreign key(id_pedido) references pedido(id)
  on delete cascade on update cascade,
  foreign key(id_producto) references producto(id)
  on delete cascade on update cascade
);

CREATE TRIGGER ins_orden_stock after insert
ON orden
FOR each row
	update stock set stock.salidas = stock.salidas + new.cantidad , 
	stock.existencias = stock.existencias - new.cantidad	
	where stock.id_producto = new.id_producto;
	
INSERT INTO usuario (id, username, password, email)
VALUES (1,'admin', '123456', 'admin@gmail.com');

INSERT INTO empleado (id, nombres, apellidos, ci, genero, cargo, telefono, id_usuario) 
VALUES (1, 'admin', 'admin', '123456', 'M', 'Administrador', '123456', 1);


/*
create table receta (
  id int not null AUTO_INCREMENT,
  codigo varchar(16) not null,
  nombre varchar(50) not null,
  cantidad int not null,
  preparacion varchar(150) not null,
  primary key(id),
	unique key(nombre)
);

create table orden_produccion (
  id int not null AUTO_INCREMENT,
  codigo varchar(16) not null,
  cantidad int not null,
  fecha date not null,
  fecha_entrega date not null,
  id_empleado int not null,
  id_receta int not null,
  primary key(id),
	unique key(codigo),
  foreign key(id_empleado) references empleado(id)
  on delete cascade on update cascade,
  foreign key(id_receta) references receta(id)
  on delete cascade on update cascade
);


create table formula (
  id int not null AUTO_INCREMENT,
  cantidad int not null,
  unidad varchar(15) not null,
  id_producto int not null,
  id_receta int not null,
  primary key(id),
	unique key(id_receta,id_producto),
  foreign key(id_producto) references producto(id)
  on delete cascade on update cascade,
  foreign key(id_receta) references receta(id)
  on delete cascade on update cascade
);

*/
