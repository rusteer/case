SELECT t4.province_id, t1.business_id, COUNT( t1.business_id ) 
FROM response t1, channel t2, user t3, area t4
WHERE t1.business_id = t2.id
AND t1.user_id = t3.id
AND t3.area_code = t4.area_code
AND t1.submit_time >  '2012-04-29'
GROUP BY t4.province_id, t1.business_id


SELECT t1.business_id, COUNT( t1.business_id ) 
FROM request t1, channel t2, user t3, area t4
WHERE t1.business_id = t2.id
AND t1.user_id = t3.id
AND t3.area_code = t4.area_code
AND t1.submit_time >  '2012-04-21'
AND t4.province_id =6
GROUP BY t1.business_id


select contat("update user set province_id=",t3.id,",area_id=",t2.id,"where id=",t1.id) from `user` t1,`area` t2,`province` t3 where t1.area_code=t2.area_code and t2.province_id=t3.id

 select concat("update `request` set province_id=",t2.province_id," where id=",t1.id,";") from request t1,`user` t2 where t1.user_id=t2.id into outfile "/tmp/request.sql";
 select concat("update `response` set province_id=",t2.province_id," where id=",t1.id,";") from response t1,`user` t2 where t1.user_id=t2.id into outfile "/tmp/response.sql";
 
 mysqldump –uroot –pz1252577 case < request.sql