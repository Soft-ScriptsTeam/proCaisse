protected $id;

    /**
     * @var int
     */
    protected $productId;
    
    /**
     * @var int
     */
    protected $quantity;
    
    /**
     * @var string
     */
    protected $stockId;

    /**
     * @var string
     */
    protected $supplierId;

    /**
     * @var string
     */
    protected $label;

CREATE TABLE Inventories (
id INT(6) AUTO_INCREMENT PRIMARY KEY,
label VARCHAR(30)  NOT NULL,
date_facture VARCHAR(30) NOT NULL,
date_paiement VARCHAR(30) NOT NULL,
status INT(6),
stock_id INT(6),
supplier_id INT(6)
)

CREATE TABLE InventoryInputs (
inv_id INT(6) ,
product_id INT(6) ,
quantity INT(6) NOT NULL,
recieved INT(6),
PRIMARY KEY (inv_id , product_id),
FOREIGN KEY (product_id)
        REFERENCES products (id)
        ON UPDATE RESTRICT ON DELETE CASCADE,
FOREIGN KEY (inv_id)
        REFERENCES Inventories (id)
        ON UPDATE RESTRICT ON DELETE CASCADE
)

 `label`, `date_facture`, `date_paiement`, `status`, `stock_id`, `supplier_id` FROM `inventories`, `stores`, `suppliers` WHERE ( `inventories`.`stock_id` =`stores`.`id` or `inventories`.`stock_id` =0)and `inventories`.`supplier_id` = `suppliers`.`id`  "