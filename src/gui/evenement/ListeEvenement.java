/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui.evenement;

import com.codename1.components.MultiButton;
import com.codename1.io.Log;
import com.codename1.ui.Button;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import entite.Evenement;
import gui.evenement.AjouterEvenement;
import java.util.ArrayList;
import service.ServiceEvenement;

/**
 *
 * @author Nidhal
 */
public class ListeEvenement extends Form {

    public static ArrayList<Evenement> events = new ArrayList<>();
    
    public ListeEvenement() {
        //setLayout(BoxLayout.y());
        setTitle("Liste des evements");
            
        events = ServiceEvenement.getInstance().getAllEvenements();
        
        Button btn = new Button("Ajouter");
        addAll(btn);
        btn.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent evt) {
                new AjouterEvenement().show();
            }
        });

        Container list = new Container(BoxLayout.y());
        list.setScrollableY(true);
        for (Evenement e : events) {
            MultiButton mb = new MultiButton(e.getNom());
            // Label nom = new Label(e.getNom());

            mb.setTextLine2(e.getDescription());
            mb.addActionListener((evt) -> {

                new DetailsEvenement(e.getId()).show();

            });
            //Label desription = new Label(e.getDescription());
            list.add(mb);

        }

        addAll(list);
    }

}
