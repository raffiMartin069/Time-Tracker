SELECT e.emp_id, e.lname, e.mname, e.fname,
 e.birth_date, e.hired_date, ec.email,
  ec.ecn, p.position_name, s.shift_name,
   es.emp_stat_name, es.req_hrs 
FROM employee e 
INNER JOIN employee_credential ec ON e.emp_id = ec.emp_id 
INNER JOIN position p ON ec.position_id = p.position_id 
INNER JOIN shift s ON ec.shift_id = s.shift_id 
INNER JOIN employment_status es ON ec.emp_stat_id = es.emp_stat_id 
WHERE e.status = true; 