<?php

class InstructeurModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getInstructeurs()
    {
        $sql = "SELECT Id
                      ,Voornaam
                      ,Tussenvoegsel
                      ,Achternaam
                      ,Mobiel
                      ,DatumInDienst
                      ,AantalSterren
                      ,IsActief
                FROM  Instructeur
                ORDER BY AantalSterren DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getToegewezenVoertuigen($Id)
    {
        $sql = "SELECT      
                            VOER.Id
                            ,VOER.Type
                            ,VOER.Kenteken
                            ,VOER.Bouwjaar
                            ,VOER.Brandstof
                            ,TYVO.TypeVoertuig
                            ,TYVO.RijbewijsCategorie
                ,(select count(*) > 1 as test from VoertuigInstructeur where VoertuigId = VOER.Id) as test

                FROM        Voertuig    AS  VOER
                
                INNER JOIN  TypeVoertuig AS TYVO
        
                ON          TYVO.Id = VOER.TypeVoertuigId
                
                INNER JOIN  VoertuigInstructeur AS VOIN
                
                ON          VOIN.VoertuigId = VOER.Id
                
                WHERE       VOIN.InstructeurId = $Id
                
                AND         VOIN.IsActief = 1
                
                ORDER BY    TYVO.RijbewijsCategorie ASC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }
    public function getToegewezenVoertuig($Id, $instructeurId)
    {
        $sql = "SELECT      
                            VOER.Id
                            ,VOER.Type
                            ,VOER.Kenteken
                            ,VOER.Bouwjaar
                            ,VOER.Brandstof
                            ,TYVO.TypeVoertuig
                            ,TYVO.RijbewijsCategorie


                FROM        Voertuig    AS  VOER
                
                INNER JOIN  TypeVoertuig AS TYVO

                ON          TYVO.Id = VOER.TypeVoertuigId
                
                INNER JOIN  VoertuigInstructeur AS VOIN
                
                ON          VOIN.VoertuigId = VOER.Id
                
                WHERE       VOIN.InstructeurId = $instructeurId AND VOER.Id = $Id
                
                ORDER BY    TYVO.RijbewijsCategorie DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getInstructeurById($Id)
    {
        $sql = "SELECT Voornaam
                      ,Tussenvoegsel
                      ,Achternaam
                      ,DatumInDienst
                      ,AantalSterren
                      ,IsActief
                FROM  Instructeur
                WHERE Id = $Id";

        $this->db->query($sql);

        return $this->db->single();
    }

    // function updateVoertuig($id)
    // {
    //     $sql = "UPDATE Voertuig SET Type = :type, Brandstof = :brandstof, Kenteken = :kenteken WHERE Id = $id";
    //     $this->db->query($sql);
    //     $this->db->bind(':type', $_POST['type']);
    //     // $this->db->bind(':brandstof', $_POST['brandstof']);
    //     $this->db->bind(':kenteken', $_POST['kenteken']);
    //     return $this->db->resultSet();
    // }
    function updateVoertuig($id)
    {
        $sql = "UPDATE Voertuig AS Voertuig
        JOIN TypeVoertuig AS TypeVoertuig
        ON Voertuig.TypeVoertuigId = TypeVoertuig.Id
        SET Voertuig.Type = :type, Voertuig.Brandstof = :brandstof, Voertuig.Kenteken = :kenteken, TypeVoertuig.TypeVoertuig = :typevoertuig
        WHERE Voertuig.Id = $id";


        $this->db->query($sql);
        $this->db->bind(':type', $_POST['type']);
        $this->db->bind(':brandstof', $_POST['brandstof']);
        $this->db->bind(':kenteken', $_POST['kenteken']);
        $this->db->bind(':typevoertuig', $_POST['typevoertuig']);
        return $this->db->resultSet();
    }

    // aan de scenario 2 werken
    //     function getToegewezenInstructeur($id){
    // $sql = "SELECT Id
    //         FROM  Instructeur
    //         WHERE "
    //     }
    function updateInstructeur($id)
    {
        $sql = "UPDATE VoertuigInstructeur
                SET InstructeurId = :instructeurid
                WHERE voertuigId = $id";

        $this->db->query($sql);
        $this->db->bind(':instructeurid', $_POST['instructeur']);
        return $this->db->resultSet();
    }

    function getNietToegewezenVoertuigen()
    {
        // $sql = "SELECT V.Id, V.Type, V.Kenteken, V.Bouwjaar, V.Brandstof, TV.TypeVoertuig, TV.RijbewijsCategorie 
        //         FROM Voertuig V
        //         LEFT JOIN VoertuigInstructeur VI
        //         ON V.Id = VI.VoertuigId
        //         INNER JOIN TypeVoertuig TV
        //         ON TV.Id = V.TypeVoertuigId
        //         WHERE InstructeurId IS NULL";

        $sql = "SELECT V.Id, V.Type, V.Kenteken, V.Bouwjaar, V.Brandstof , TV.TypeVoertuig, TV.RijbewijsCategorie
                        FROM Voertuig V
                        LEFT JOIN VoertuigInstructeur VI
                        ON V.Id = VI.VoertuigId
                        AND VI.IsActief = 1
                        INNER JOIN TypeVoertuig TV
                        ON TV.Id = V.TypeVoertuigId
                        WHERE VI.InstructeurId IS NULL";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    function getNietToegewezenVoertuig($voertuigId)
    {
        $sql = "SELECT V.Id, V.Type, V.Kenteken, V.Bouwjaar, V.Brandstof, TV.TypeVoertuig, TV.RijbewijsCategorie 
                FROM Voertuig V
                LEFT JOIN VoertuigInstructeur VI
                ON V.Id = VI.VoertuigId
                INNER JOIN TypeVoertuig TV
                ON TV.Id = V.TypeVoertuigId
                WHERE VI.InstructeurId IS NULL 
                AND V.Id = $voertuigId";

        $this->db->query($sql);
        return $this->db->resultSet();
    }


    function updateNietToegewezenInstructeur($voertuigId)
    {
        $sql = "INSERT INTO VoertuigInstructeur (InstructeurId, VoertuigId, DatumToekenning, IsActief, Opmerkingen, DatumAangemaakt, DatumGewijzigd) 
        VALUES (:instructeurid, :voertuigId, SYSDATE(6), 1, NULL, SYSDATE(6), SYSDATE(6))";

        $this->db->query($sql);
        $this->db->bind(':instructeurid', $_POST['instructeur']);
        $this->db->bind(':voertuigId', $voertuigId);

        // $this->db->bind(':voertuigid', $voertuigId); 
        return $this->db->resultSet();
    }

    function addVoertuigToInstructeur($voertuigId, $instructeurId)
    {
        $sql = "INSERT INTO VoertuigInstructeur (VoertuigId, InstructeurId, DatumToekenning, DatumAangemaakt, DatumGewijzigd) VALUES (:voertuigId, :instructeurId, now(), sysdate(6), sysdate(6))";
        $this->db->query($sql);
        $this->db->bind(':voertuigId', $voertuigId);
        $this->db->bind(':instructeurId', $instructeurId);
        return $this->db->resultSet();
    }
    function getVoertuigInstructeur($id)
    {
        $sql = "SELECT instructeurid as Id FROM voertuigInstructeur
        where voertuigid = ?";

        $this->db->query($sql);
        $this->db->bind(1, $id);
        return $this->db->single();
    }

    function unassignInstructeur($voertuigId, $instructeurId)
    {
        $sql = "DELETE FROM VoertuigInstructeur WHERE InstructeurId = $instructeurId AND VoertuigId = $voertuigId";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    function deleteVoertuig($voertuigId)
    {
        $sql = "DELETE FROM Voertuig WHERE Id = $voertuigId";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    function getAllVehicles()
    {
        $sql = "SELECT v.Id, tv.TypeVoertuig, v.Type, v.Kenteken, v.Bouwjaar, v.Brandstof, tv.Rijbewijscategorie,
            CONCAT(i.Voornaam, ' ', i.Tussenvoegsel, ' ', i.Achternaam) AS InstructeurNaam
            FROM Voertuig v
            LEFT JOIN TypeVoertuig tv ON v.TypeVoertuigId = tv.Id
            LEFT JOIN VoertuigInstructeur vi ON v.Id = vi.VoertuigId
            LEFT JOIN Instructeur i ON vi.InstructeurId = i.Id";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    function deleteVoertuigfromAll($voertuigId)
    {
        $sql = "DELETE FROM VoertuigInstructeur
        WHERE VoertuigId = $voertuigId;
        
        DELETE FROM Voertuig
        WHERE Id = $voertuigId;";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    function updateNietActief($instructeurId)
    {
        $sql = "UPDATE Instructeur
                SET IsActief = 0,
                    DatumGewijzigd = SYSDATE(6)
                WHERE Id = $instructeurId";
        $this->db->query($sql);
        return $this->db->execute();
    }
    function updateIsActief($instructeurId)
    {
        $sql = "UPDATE Instructeur
                SET IsActief = 1,
                    DatumGewijzigd = SYSDATE(6)
                WHERE Id = $instructeurId";
        $this->db->query($sql);
        return $this->db->resultSet();
    }
    function deleteVoertuigFromInstructeur($instructeurId, $voertuigId)
    {
        $sql = "DELETE VoertuigInstructeur
        WHERE InstructeurId = $instructeurId AND VoertuigId = $voertuigId";
        $this->db->query($sql);
        $this->db->execute();
    }
    function deleteInstructeur($instructeurId)
    {

        try {
            $sql = "DELETE FROM VoertuigInstructeur
               WHERE InstructeurId = $instructeurId";
            $this->db->query($sql);
            $this->db->execute();
            $sql = "DELETE FROM Instructeur
               WHERE Id = $instructeurId";

            $this->db->query($sql);
            $this->db->execute();
        } catch (PDOException $e) {
            return 0;
        }
        return 1;
    }
}
