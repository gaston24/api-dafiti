<?php
function new_daf_api(){
	include __DIR__."/../AccesoDatos/conn.php";
	
	//////////////TOMA CADA UNO DE LOS PEDIDOS QUE NO ESTAN EN AUDITORIA
	
	$sqlPedidosNuevos = "
	SET DATEFORMAT YMD

	SELECT A.CANT_ART, A.PRICE, B.* FROM SJ_DAFITI_API_ENCABEZADO A
	INNER JOIN SJ_DAFITI_API_CLIENTE B
	ON A.ORDER_ID = B.ORDER_ID AND A.ORDER_NUMBER = B.ORDER_NUMBER
	WHERE CAST(A.ORDER_NUMBER AS VARCHAR) COLLATE Latin1_General_BIN NOT IN 
	(SELECT NRO_ORDEN_ECOMMERCE FROM SOF_AUDITORIA)	

	";
	
	$pedidos = sqlsrv_query( $cid_central, $sqlPedidosNuevos );

    // $rows = array();
    
    // while( $v = sqlsrv_fetch_array( $pedidos) ) {
    //     $rows[] = $v;
    // }

    // print_r( $rows );

    // return;

	while( $v = sqlsrv_fetch_array( $pedidos) ) {
		// $rows[] = $v;


		$ordenEcommerce = $v['ORDER_NUMBER'];
		$totalPedi = $v['PRICE'];

		$cliente = $v['FIRST_NAME'].' '.$v['LAST_NAME'];
		$cliente = str_replace("'","''", $cliente);


		$codPostal = $v['C_POSTAL'];

		$direccion = $v['DIRECCION_1'].' '.$v['DIRECCION_2'].' '.$v['CIUDAD'];
		$direccion = substr($direccion, 0, 30);
		$direccion = str_replace("'","''", $direccion);

		$localidad = $v['CIUDAD'];
		$localidad = substr($localidad, 0, 20);
		$localidad = str_replace("'","''", $localidad);

		$dni = $v['DNI'];
		$telefono = '';
		
        $direccion_completa = $direccion.' '.$codPostal.' '.$localidad;
        
        echo $ordenEcommerce.' '.$cliente.' '.$totalPedi.' '.$direccion_completa.' '.$dni.'<br>';

		
		//////////////MODIFICA NUMERACION
		$sqlProxNumero =
		"EXEC SJ_PEDIDOS_PROX";

        $stmt = sqlsrv_prepare( $cid_central, $sqlProxNumero );

        sqlsrv_execute($stmt);
		
		
		//////////////VARIABLE DE NUMERO ACTUAL
		$sqlNumActual =
		"SELECT PROXIMO FROM SJ_TEMP_PEDIDOS WHERE TALONARIO = 98";

        
        $stmt = sqlsrv_query( $cid_central, $sqlNumActual );
        while( $v = sqlsrv_fetch_array( $stmt) ) {
            $numPedido = ' 00002'.$v['PROXIMO'];
        }
		
		
		
		
		
		
		//////////////INSERTAR ENCABEZADO GVA21
		
		$sqlPedEncabezado =
		"

		EXEC SJ_PEDIDOS_ENCABEZADO_SIMPLE 101, '$ordenEcommerce', '$cliente', '$numPedido', $totalPedi

		";
       
        
		
		$stmt = sqlsrv_prepare( $cid_central, $sqlPedEncabezado );

        sqlsrv_execute($stmt);

		
		////////////// RECORRER DETALLE DE PEDIDO PARA INSERTAR DETALLE

		$sqlPedidoDetalle =
		"
        SELECT * FROM SJ_DAFITI_API_DETALLE 
        WHERE CAST(ORDER_NUMBER AS VARCHAR) COLLATE Latin1_General_BIN = '$ordenEcommerce'

        ";

        $resultPedidoDetalle = sqlsrv_query( $cid_central, $sqlPedidoDetalle );
        $renglonPedido = 1;

        while( $v = sqlsrv_fetch_array( $resultPedidoDetalle) ) {
	

			$codArt = $v['COD_ARTICU'];
			$cantArt = 1;
            $precioArt = $v['PRECIO_ART'];

            // echo $renglonPedido.' '.$codArt.' '.$cantArt.' '.$precioArt.'<br>';
			
			
			////////////// INSERTAR DETALLE DE PEDIDO GVA03
			
			$sqlDetalle = 
			"
			EXEC SJ_PEDIDOS_DETALLE_SIMPLE '12', '$codArt', $cantArt, $renglonPedido, 101, '$numPedido', 'GTDAF'  
			";
            
            $stmt = sqlsrv_prepare( $cid_central, $sqlDetalle );

            sqlsrv_execute($stmt);
			
			
			$renglonPedido++;
			
        }
        

		
		////////////// INSERTAR DATOS DEL CLIENTE GVA38

		
		$sqlDatosCliente = 
		"
		SET DATEFORMAT YMD
		
		INSERT INTO GVA38
		(
		FILLER, ALI_ADI_IB, ALI_FIJ_IB, ALI_NOCATE, AL_FIJ_IB3, COD_PROVIN, C_POSTAL, DOMICILIO, E_MAIL, IB_L, IB_L3, II_D, II_IB3, II_L,  IVA_D, IVA_L, LOCALIDAD, N_COMP, N_CUIT, N_ING_BRUT, N_IVA, 
		PORC_EXCL, RAZON_SOCI, SOBRE_II, SOBRE_IVA, TALONARIO, TELEFONO_1, TELEFONO_2, TIPO, TIPO_DOC, T_COMP, DESTINO_DE, CLA_IMP_CL, RECIBE_DE, AUT_DE, WEB, COD_RUBRO, CTA_CLI, CTO_CLI, IDENTIF_AFIP, 
		DIRECCION_ENTREGA, CIUDAD_ENTREGA, COD_PROVINCIA_ENTREGA, LOCALIDAD_ENTREGA, CODIGO_POSTAL_ENTREGA, TELEFONO1_ENTREGA, TELEFONO2_ENTREGA, ID_CATEGORIA_IVA, CONSIDERA_IVA_BASE_CALCULO_IIBB, 
		CONSIDERA_IVA_BASE_CALCULO_IIBB_ADIC, MAIL_DE, FECHA_NACIMIENTO, SEXO
		)
		VALUES
		(
		'', 0, 0, 0, 0, '02', '$codPostal', '$direccion', '', 'N', 0, 'N', 0, 'N', 'N', 'S', '$localidad', '$numPedido', '$dni', '', '',
		0, '$cliente', 'N', 'N', 101, '$telefono', '', '', 96, 'PED', 'T', '', 0, 0, '', '', 0, '', '', 
		'$direccion', '$localidad', '02', '$localidad', '$codPostal', '$telefono', '$ordenEcommerce', 2, 'N', 'N', NULL, '1800-01-01', NULL
		)
		";
		// echo $sqlDatosCliente;
		// return;
        $stmt = sqlsrv_prepare( $cid_central, $sqlDatosCliente );

        // echo $sqlDatosCliente.'<br>';

        sqlsrv_execute($stmt);
        
		
		////////////// INSERTAR DATOS EN AUDITORIA
		
		$sqlAuditoria =
		"
		SET DATEFORMAT YMD
		
		INSERT INTO SOF_AUDITORIA
		(
		ORIGEN, NRO_ORDEN_ECOMMERCE, NRO_PEDIDO, FECHA_PEDIDO, RAZON_SOCIAL, COD_ARTICULO, DESCRIPCION, CANTIDAD_A_FACTURAR, TOTAL_PEDIDO, NOMBRE_MEDIO_PAGO, IMPORTE_PAGO, OBSERV_AUDITORIA, 
		NRO_COMP, NRO_TRACKING, OBSERV_TRACKING, ID_MERCADOPAGO
        )
        
		SELECT 
        'DAA', ORDER_NUMBER, '$numPedido', CAST(GETDATE() AS date), '$cliente', A.COD_ARTICU, LEFT(B.DESCRIPCIO, 30), 1, PRECIO_ART, 'Pay U', PRECIO_ART, 'Pay U', NULL, 0, NULL, NULL
        FROM 
        (
        SELECT A.CANT_ART, A.PRICE, B.*, C.COD_ARTICU, C.PRECIO_ART FROM SJ_DAFITI_API_ENCABEZADO A 
        INNER JOIN SJ_DAFITI_API_CLIENTE B 
        ON A.ORDER_ID = B.ORDER_ID AND A.ORDER_NUMBER = B.ORDER_NUMBER
        INNER JOIN SJ_DAFITI_API_DETALLE C
        ON A.ORDER_ID = C.ORDER_ID AND A.ORDER_NUMBER = C.ORDER_NUMBER
        ) A
        INNER JOIN STA11 B
        ON A.COD_ARTICU collate Latin1_General_BIN = B.COD_ARTICU

        WHERE CAST(ORDER_NUMBER AS VARCHAR) collate Latin1_General_BIN
        NOT IN (SELECT NRO_ORDEN_ECOMMERCE FROM SOF_AUDITORIA)
        AND CAST(ORDER_NUMBER AS VARCHAR) collate Latin1_General_BIN = '$ordenEcommerce'
		";
		
        $stmt = sqlsrv_prepare( $cid_central, $sqlAuditoria );
        
        // echo $sqlAuditoria.'<hr>';

        sqlsrv_execute($stmt);



	}


}


?>