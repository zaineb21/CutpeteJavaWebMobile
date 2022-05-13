/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package service;

import com.codename1.io.ConnectionRequest;

/**
 *
 * @author Nidhal
 */
public class ServiceReservation {
      private ConnectionRequest req;
    public static ServiceReservation instance= null;
     public static ServiceReservation  getInstance() 
    {
        if(instance==null)
            instance =new ServiceReservation ();
        return instance;
    }
       public ServiceReservation() {
        req =new ConnectionRequest();
    }
    
       
       
       //
       
}
