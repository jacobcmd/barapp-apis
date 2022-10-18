DELIMITER //

CREATE TRIGGER after_insert_addOrden
AFTER INSERT ON ordenes
FOR EACH ROW
BEGIN
    UPDATE pulceras SET total = total + ((SELECT precio FROM productos WHERE id = NEW.id_producto) * NEW.cantidad) WHERE id = NEW.id_pulcera;
END;
//

DELIMITER;

DELIMITER //

CREATE TRIGGER after_delete_addOrden
AFTER DELETE ON ordenes
FOR EACH ROW
BEGIN
    UPDATE pulceras SET total = total - ((SELECT precio FROM productos WHERE id = OLD.id_producto) * OLD.cantidad) WHERE id = OLD.id_pulcera;
END;
//

DELIMITER;