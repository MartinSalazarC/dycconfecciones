CREATE DEFINER=`dyccompe_admin`@`localhost` PROCEDURE `sp_con_reclamo_x_cod`(
	IN `codigo` INT(11)



)
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT ''
BEGIN
 
select c.cod_reclamo, 
       f_con_des_mae_tabla_det_x_cod(c.tip_doc, 'D') tip_doc,
       c.num_doc, 
			 c.nom_reclam, 
			 c.ape_reclam, 
			 c.dir_reclam, 
			 c.telef_reclam, 
			 c.correo_reclam, 
			 c.ind_menor_edad, 
			 c.nom_tutor,
			 f_con_nombre_local_x_cod_local(c.cod_local, 'B') nom_local,
       f_con_des_mae_tabla_det_x_cod(c.tip_bien, 'D') tip_bien,
       c.monto_reclam, 
			 c.desc_reclam,
       f_con_des_mae_tabla_det_x_cod(c.tip_reclam, 'D') tip_reclamo,
       c.det_reclam, 
			 c.pedido_reclam, 
			 c.fec_registro, 
			 c.fec_rpta, 
			 c.rpta_reclam,
			 c.estado_reclam
from mae_reclamo c
where c.cod_reclamo = codigo;
 
END