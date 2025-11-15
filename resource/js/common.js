var decode = (cadena)=>{
         
        const n = /&ntilde;/gi;
        const N = /&Ntilde;/gi;

        const a = /&aacute;/gi;
        const e = /&eacute;/gi;
        const i = /&iacute;/gi;
        const o = /&oacute;/gi;
        const u = /&uacute;/gi;

        const A = /&Aacute;/gi;
        const E = /&Eacute;/gi;
        const I = /&Iacute;/gi;
        const O = /&Oacute;/gi;
        const U = /&Uacute;/gi;

        
        cadena = cadena.replace(n, "ñ");
        cadena = cadena.replace(N, "Ñ");

        cadena = cadena.replace(a, "á");
        cadena = cadena.replace(e, "é");
        cadena = cadena.replace(i, "í");
        cadena = cadena.replace(o, "ó");
        cadena = cadena.replace(u, "ú");

        cadena = cadena.replace(A, "Á");
        cadena = cadena.replace(E, "É");
        cadena = cadena.replace(I, "Í");
        cadena = cadena.replace(O, "Ó");
        cadena = cadena.replace(U, "Ú");
        cadena = cadena.replace('&amp;&quot;','"');
        cadena = cadena.replaceAll('&quot;','"');
        cadena = cadena.replaceAll('&amp;','&');
        cadena = cadena.replaceAll('iexcl;','¡');
        cadena = cadena.replaceAll('&uml;','¨');
        cadena = cadena.replaceAll('&iquest;','¿');
    return(cadena);
}