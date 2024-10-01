<?php
$lang->deploy->common           = 'Plan de d��ploiement';
$lang->deploy->create           = 'Cr��er un plan de d��ploiement';
$lang->deploy->view             = 'D��tails du d��ploiement';
$lang->deploy->finish           = 'Termin';
$lang->deploy->finishAction     = 'D��ploiement termin��';
$lang->deploy->edit             = 'Editer';
$lang->deploy->editAction       = 'Editer d��ploiement';
$lang->deploy->delete           = 'Supprimer';
$lang->deploy->deleteAction     = 'Supprimer d��ploiement';
$lang->deploy->deleted          = 'Deleted';
$lang->deploy->activate         = 'Activer';
$lang->deploy->activateAction   = 'Activer d��ploiement';
$lang->deploy->browse           = 'Deploiement';
$lang->deploy->scope            = 'Scope d��ploiement';
$lang->deploy->manageScope      = "Champ d'application de la gestion";
$lang->deploy->cases            = 'CasTests';
$lang->deploy->notify           = 'Notifier';
$lang->deploy->casesAction      = 'Cas de d��ploiement';
$lang->deploy->linkCases        = 'Associer CasTest';
$lang->deploy->unlinkCase       = 'Dissocier CasTest';
$lang->deploy->steps            = 'Etape d��ploiement';
$lang->deploy->manageStep       = '�0�7tapes administratives';
$lang->deploy->finishStep       = 'Finir Etape';
$lang->deploy->activateStep     = 'Activer Etape';
$lang->deploy->assignTo         = 'Assigner ';
$lang->deploy->assignAction     = 'Assigner Etape';
$lang->deploy->editStep         = 'Editer Etape';
$lang->deploy->deleteStep       = 'Supprimer Etape';
$lang->deploy->viewStep         = 'D��tails Etape';
$lang->deploy->batchUnlinkCases = 'Dissocier par lot';
$lang->deploy->createdDate      = 'Date de cr��ation';

$lang->deploy->name       = 'Nom du Plan';
$lang->deploy->desc       = 'Description';
$lang->deploy->members    = 'Membres';
$lang->deploy->hosts      = 'Serveurs';
$lang->deploy->service    = 'Service';
$lang->deploy->product    = 'Product';
$lang->deploy->release    = 'Release';
$lang->deploy->package    = 'Package URL';
$lang->deploy->begin      = "C'est parti";
$lang->deploy->end        = 'Fin';
$lang->deploy->status     = 'Statut';
$lang->deploy->owner      = 'Propri��taire';
$lang->deploy->stage      = 'Phase';
$lang->deploy->ditto      = 'Idem';
$lang->deploy->manageAB   = 'Gestion';
$lang->deploy->title      = 'Titre';
$lang->deploy->content    = 'Contenu';
$lang->deploy->assignedTo = 'Assign';
$lang->deploy->finishedBy = 'Fini par';
$lang->deploy->createdBy  = 'Cr��ateur';
$lang->deploy->result     = 'Resultat';
$lang->deploy->updateHost = 'Mise jour Serveurs';
$lang->deploy->removeHost = 'Serveurs supprimer';
$lang->deploy->addHost    = 'Nouveau Serveur';
$lang->deploy->hadHost    = 'H��bergement';

$lang->deploy->lblBeginEnd = 'P��riode';
$lang->deploy->lblBasic    = 'Information de Base';
$lang->deploy->lblProduct  = 'Liens';
$lang->deploy->lblMonth    = 'Courant';
$lang->deploy->toggle      = 'Bascule';

$lang->deploy->monthFormat = 'M Y';

$lang->deploy->statusList['wait'] = 'En attente';
$lang->deploy->statusList['done'] = 'Fait';

$lang->deploy->dateList['today']     = "Aujourd'hui";
$lang->deploy->dateList['tomorrow']  = 'Demain';
$lang->deploy->dateList['thisweek']  = 'Cette semaine';
$lang->deploy->dateList['thismonth'] = 'Ce mois';
$lang->deploy->dateList['done']      = $lang->deploy->statusList['done'];

$lang->deploy->stageList['wait']    = 'Avant d��ploiement';
$lang->deploy->stageList['doing']   = 'En d��ploiement';
$lang->deploy->stageList['testing'] = "Tests d'acceptance";
$lang->deploy->stageList['done']    = 'Apr��s d��ploiement';

$lang->deploy->resultList['']        = '';
$lang->deploy->resultList['success'] = 'Fait';
$lang->deploy->resultList['fail']    = 'Echec';

$lang->deploy->confirmDelete     = 'Voulez - vous supprimer ce d��ploiement?';
$lang->deploy->confirmDeleteStep = 'Voulez - vous supprimer cette ��tape?';
$lang->deploy->errorTime         = "L'heure de fin doit ��tre sup��rieure �� l'heure de d��but!";
$lang->deploy->errorStatusWait   = 'If the status is Waiting, the FinishedBy should be empty';
$lang->deploy->errorStatusDone   = "Finishby ne doit pas ��tre vide si l'��tat est termin��";
$lang->deploy->errorOffline      = "L'h�0�0te dans la suppression et l'ajout du service ne peut pas exister en m��me temps.";
$lang->deploy->resultNotEmpty    = 'Le r��sultat ne peut pas ��tre vide';

$lang->deploystep = new stdClass();
$lang->deploystep->status       = $lang->deploy->status;
$lang->deploystep->assignedTo   = $lang->deploy->assignedTo;
$lang->deploystep->finishedBy   = $lang->deploy->finishedBy;
$lang->deploystep->finishedDate = 'Finished Date';
$lang->deploystep->begin        = $lang->deploy->begin;
$lang->deploystep->end          = $lang->deploy->end;
