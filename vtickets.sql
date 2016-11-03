select tickets.ID AS ID,
	tickets.ClienteId AS ClienteId,
	tickets.Data AS Data,
	tickets.Oggetto AS Oggetto,
	tickets.Descrizione AS Descrizione,
	tickets.CategoriaId AS CategoriaId,
	tickets.StatoId AS StatoId,
	tickets.RepartoId AS RepartoId,
	tickets.OperatoreId AS OperatoreId,
	tickets.Owner AS Owner,
	categorie.Nome AS Categoria,
	stati.Nome AS Stato,
	reparti.Nome AS Reparto,
	CONCAT(operatori.Cognome, ' ', operatori.Nome) AS Operatore,
	CONCAT(clienti.Cognome, ' ', clienti.Nome) AS Cliente
from (((tickets 
	left join categorie on((tickets.CategoriaId = categorie.ID))) 
	left join stati on((tickets.StatoId = stati.ID))) 
	left join clienti on((tickets.ClienteId = clienti.ID)))
	left join reparti on tickets.RepartoId = reparti.ID
	left join operatori on tickets.OperatoreId = operatori.ID