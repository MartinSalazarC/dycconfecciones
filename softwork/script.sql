update `mae_menu_general` set `cod_ventana`='502',`cod_nivel_ventana`='2',`des_ventana`='Administrar Mensajes de Contacto',`des_opcion`='pgadmmensajes.php',`cod_ventana_ant`='5',`ind_hijos`='0',`num_orden`='2' where `cod_ventana`='502'
insert into `mae_menu_general`(`cod_ventana`,`cod_nivel_ventana`,`des_ventana`,`des_opcion`,`cod_ventana_ant`,`ind_hijos`,`num_orden`) values ( '503','2','Administrar Reclamos/Sugerencias','pgadmreclamos.php','5','0','3')

/**********************************************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS `dyccompe_principal`.`sp_con_not_msj_reclamo`$$

CREATE PROCEDURE `dyccompe_principal`.`sp_con_not_msj_reclamo`()

 BEGIN

  select count(*) from mae_reclamo where estado_reclam = 'D023';

 END$$

DELIMITER ;

/**********************************************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS `dyccompe_principal`.`sp_con_not_msj_reclamo_max`$$

CREATE PROCEDURE `dyccompe_principal`.`sp_con_not_msj_reclamo_max`()

 BEGIN
 
 select count(*) 
 from mae_reclamo 
 where estado_reclam = 'D023'
   and DATEDIFF(CURDATE(), fec_registro) > 25;
 
 
 END$$

DELIMITER ;


/**********************************************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS `dyccompe_principal`.`sp_con_cab_msj_reclamo`$$

CREATE PROCEDURE `dyccompe_principal`.`sp_con_cab_msj_reclamo`(
in vi_fec_registro_ini date, 
in vi_fec_registro_fin date, 
in vi_tip_reclam varchar(4), 
in vi_estado_reclam varchar(4)
)

 BEGIN
 
 if vi_fec_registro_ini <> '' and vi_fec_registro_fin <> '' then 
   
   select cod_reclamo, 
          f_con_des_mae_tabla_det_x_cod(tip_doc, 'C') as des_tip_doc,
          num_doc,  
          fec_registro,  
          DATEDIFF(CURDATE(), fec_registro) dias,  
          f_con_des_mae_tabla_det_x_cod(estado_reclam, 'D') des_est_rec,
          f_con_des_mae_tabla_det_x_cod(tip_reclam, 'D') des_tip_reg
   from mae_reclamo
   where (date(fec_registro) >= vi_fec_registro_ini and date(fec_registro) <= vi_fec_registro_fin)
     and (tip_reclam = vi_tip_reclam or tip_reclam like vi_tip_reclam)
     and (estado_reclam = vi_estado_reclam or estado_reclam like vi_estado_reclam);
   
 else
   
   select cod_reclamo, 
          f_con_des_mae_tabla_det_x_cod(tip_doc, 'C') as des_tip_doc,
          num_doc,  
          fec_registro,  
          DATEDIFF(CURDATE(), fec_registro) dias,  
          f_con_des_mae_tabla_det_x_cod(estado_reclam, 'D') des_est_rec,
          f_con_des_mae_tabla_det_x_cod(tip_reclam, 'D') des_tip_reg
   from mae_reclamo
   where (tip_reclam = vi_tip_reclam or tip_reclam like vi_tip_reclam)
     and (estado_reclam = vi_estado_reclam or estado_reclam like vi_estado_reclam);
   
 end if;
 
 END$$

DELIMITER ;


/**********************************************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS `dyccompe_principal`.`sp_con_cab_msj_contacto`$$

CREATE DEFINER=`dyccompe_admin`@`localhost` PROCEDURE `sp_con_cab_msj_contacto`(
 IN `vi_palabra` VARCHAR(20),
 IN `vi_fecini` DATE,
 IN `vi_fecfin` DATE,
 IN `vi_estado` CHAR(1)
)
BEGIN
 
 if vi_fecini <> '' and vi_fecfin <> '' then 
   
   select cod_mensaje, asunto, fec_registro, ind_atencion
   from mae_msj_contacto 
   where (date(fec_registro) >= vi_fecini and date(fec_registro) <= vi_fecfin)
     and (ind_atencion = vi_estado or ind_atencion like vi_estado)
     and (asunto like concat('%', asunto, '%') or mensaje like concat('%', asunto, '%'));
   
 else
   
   select cod_mensaje, asunto, fec_registro, ind_atencion
   from mae_msj_contacto 
   where (ind_atencion = vi_estado or ind_atencion like vi_estado)
     and (asunto like concat('%', asunto, '%') or mensaje like concat('%', asunto, '%'));  
   
 end if;
 
 END$$

DELIMITER ;


/**********************************************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS `dyccompe_principal`.`sp_con_img_usuario`$$

CREATE DEFINER=`dyccompe_admin`@`localhost` PROCEDURE `sp_con_img_usuario`(
in vi_cod_usuario varchar(20)
)
BEGIN
 
 select nom_arch_img from mae_usuario where cod_usuario = vi_cod_usuario;
 
 END$$

DELIMITER ;

/**********************************************************************************************************/

DELIMITER $$

DROP PROCEDURE IF EXISTS `dyccompe_principal`.`sp_act_img_usuario`$$

CREATE PROCEDURE `dyccompe_principal`.`sp_act_img_usuario`(
in vi_cod_usuario varchar(20),
in vi_nom_arch_img varchar(10)
)
BEGIN
 
 update mae_usuario 
 set nom_arch_img = vi_nom_arch_img
 where cod_usuario = vi_cod_usuario;
 
 select 1 as error from dual;
 
 END$$

DELIMITER ;