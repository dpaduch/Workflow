# Workflow

Simple PHP library to manage the state of selected entity. The action of state changing is user defined.

Assumption:

* the entity implements specified interface
* the list of states and actions is not closed
 
Requirements:

* possibility to fast adjust states and actions between them
* some of actions needs additional operations - fill the reason of change, confirm the change
* actions accessible after satisfying the assumptions - the role of user, relation with specified entity, the season of year
