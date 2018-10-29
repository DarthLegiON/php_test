SELECT * FROM (
	SELECT id, id_collection, name, date, price,
	    @collection_rank := IF(@current_collection = id_collection, @collection_rank + 1, 1) AS collection_rank,
	    @current_collection := id_collection 
	    FROM `products`
	    ORDER BY id_collection, date DESC
) t WHERE collection_rank <= 5;