SET @sql = NULL;
SELECT
    GROUP_CONCAT(DISTINCT
    CONCAT(
      'MAX(CASE WHEN p.name = ''',
      p.name,
      ''' THEN up.value_',
      p.type,
      ' END) AS `',
      p.name,
      '`'
    )
  ) INTO @sql
FROM properties p;

SET @sql = CONCAT('SELECT u.id AS user_id, u.email, ', @sql, '
                   FROM users u
                   LEFT JOIN users_properties up ON u.id = up.user_id
                   LEFT JOIN properties p ON up.property_id = p.id
                   GROUP BY u.id, u.email');

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
