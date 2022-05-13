/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package entite;

import java.util.Date;

/**
 *
 * @author Nidhal
 */
public class Reservation {
     private int id ;
    private int id_evenement ;
   private int  id_user ;
   private Date Date_reservation;

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getId_evenement() {
        return id_evenement;
    }

    public void setId_evenement(int id_evenement) {
        this.id_evenement = id_evenement;
    }

    public int getId_user() {
        return id_user;
    }

    public void setId_user(int id_user) {
        this.id_user = id_user;
    }

    public Date getDate_reservation() {
        return Date_reservation;
    }

    public void setDate_reservation(Date Date_reservation) {
        this.Date_reservation = Date_reservation;
    }

    public Reservation(int id, int id_evenement, int id_user, Date Date_reservation) {
        this.id = id;
        this.id_evenement = id_evenement;
        this.id_user = id_user;
        this.Date_reservation = Date_reservation;
    }

    public Reservation() {
    }

    public Reservation(int id) {
        this.id = id;
    }

    @Override
    public String toString() {
        return "Reservation{" + "id=" + id + ", id_evenement=" + id_evenement + ", id_user=" + id_user + ", Date_reservation=" + Date_reservation + '}';
    }

    
}
