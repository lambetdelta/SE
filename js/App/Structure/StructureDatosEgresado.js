var StructureDatosEgresado={
	no_control:null,
	nombre:null,
	apellido_p:null,
	apellido_m:null,
	genero:null,
	fecha_nac:null,
	curp:null,
	email:null,
	ciudad:null,
	colonia:null,
	calle:null,
	no_casa:null,
	cp:null,
	tel:null,
	init:function(
		no_control,
		nombre,
		apellido_p,
		apellido_m,
		genero,
		fecha_nac,
		curp,
		email,
		ciudad,
		colonia,
		calle,
		no_casa,
		cp,
		tel){
		StructureDatosEgresado.setNoControl(no_control);
		StructureDatosEgresado.setNombre(nombre);
		StructureDatosEgresado.setApellidoPaterno(apellido_p);
		StructureDatosEgresado.setApelllidoMaterno(apellido_m);
		StructureDatosEgresado.setGenero(genero);
		StructureDatosEgresado.setFechaNacimiento(fecha_nac);
		StructureDatosEgresado.setCurp(curp);
		StructureDatosEgresado.setEmail(email);
		StructureDatosEgresado.setCiudad(ciudad);
		StructureDatosEgresado.setCalle(calle);
		StructureDatosEgresado.setNoCasa(no_casa);
		StructureDatosEgresado.setCP(cp);
		StructureDatosEgresado.setColonia(colonia);
		StructureDatosEgresado.setTelelfono(tel);
		return StructureDatosEgresado;
	},
	setTelelfono:function(tel){
		StructureDatosEgresado.tel=tel;
	},
	getTelelfono:function(tel){
		return StructureDatosEgresado.tel;
	},
	setNoControl:function(no_control){
		StructureDatosEgresado.no_control=no_control;
	},
	setApellidoPaterno:function(apellido_p){
		StructureDatosEgresado.apellido_p=apellido_p;
	},
	setNombre:function(nombre){
		StructureDatosEgresado.nombre=nombre;
	},
	setApelllidoMaterno:function(apellido_m){
		StructureDatosEgresado.apellido_m=apellido_m;
	},
	setGenero:function(genero){
		StructureDatosEgresado.genero=genero;
	},
	setFechaNacimiento:function(fecha_nac){
		StructureDatosEgresado.fecha_nac=fecha_nac;
	},
	setCurp:function(curp){
		StructureDatosEgresado.curp=curp;
	},
	setEmail:function(email){
		StructureDatosEgresado.email=email;
	},
	setCiudad:function(ciudad){
		StructureDatosEgresado.ciudad=ciudad;
	},
	setCalle:function(calle){
		StructureDatosEgresado.calle=calle;
	},
	setColonia:function(colonia){
		StructureDatosEgresado.colonia=colonia;
	},
	setNoCasa:function(no_casa){
		StructureDatosEgresado.no_casa=no_casa;
	},
	setCP:function(cp){
		StructureDatosEgresado.cp=cp;
	}//
	,
	getNoControl:function(obj){
		return obj.no_control;
	},
	getApellidoPaterno:function(obj){
		return obj.apellido_p;
	},
	getNombre:function(obj){
		return obj.nombre;
	},
	getApelllidoMaterno:function(obj){
		return obj.apellido_m;
	},
	getGenero:function(obj){
		return obj.genero;
	},
	getFechaNacimiento:function(obj){
		return obj.fecha_nac;
	},
	getCurp:function(obj){
		return obj.curp;
	},
	getEmail:function(obj){
		return obj.email;
	},
	getCiudad:function(obj){
		return obj.ciudad;
	},
	getCalle:function(obj){
		return obj.calle;
	},
	getColonia:function(obj){
		return obj.colonia;
	},
	getNoCasa:function(obj){
		return obj.no_casa;
	},
	getCP:function(obj){
		return obj.cp;
	},
	getValueByName:function(name){
		switch (name) {
			case 'nombre':
				return this.getNombre(this);
				break;
			case 'apellido_p':
				return this.getApellidoPaterno(this);
				break;
			case 'apellido_m':
				return this.getApelllidoMaterno(this);
				break;
			case 'fecha_nac':
				return this.getFechaNacimiento(this);
				break;
			case 'curp':
			  	return this.getCurp(this);
				break;
			case 'tel':
				return this.getTelelfono(this);
				break;
			case 'email':
				return this.getEmail(this);
				break;
			case 'ciudad':
				return this.getCiudad(this);
				break;
			case 'colonia':
				return this.getColonia(this);
				break;
			case 'calle':
				return this.getCalle(this);
				break;
			case 'no_casa':
				return this.getNoCasa(this);
				break;
			case 'cp':
				return this.getCP(this);
				break;
		}

	}
}