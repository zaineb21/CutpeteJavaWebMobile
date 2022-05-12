package com.codename1.uikit.pheonixui;

import com.codename1.ui.Button;
import com.codename1.ui.layouts.FlowLayout;
import com.codename1.uikit.pheonixui.service.CartService;


public class BackOfficeWindow extends BaseForm {
    public BackOfficeWindow() {
        this(com.codename1.ui.util.Resources.getGlobalResources());
    }
    
    public BackOfficeWindow(com.codename1.ui.util.Resources resourceObjectInstance) {
        initGuiBuilderComponents(resourceObjectInstance);
        getToolbar().setTitleComponent(
                FlowLayout.encloseCenterMiddle(
                        new com.codename1.ui.Label("BACK OFFICE :: ADMIN PANEL", "Title"),
                        new com.codename1.ui.Label(String.valueOf(CartService.getInstance().getProducts().size()), "InboxNumber")
                )
        );
        installSidemenu(resourceObjectInstance);
        Button buttonProduct = new Button("Product");
        Button buttonCommande = new Button("Commande");
        Button buttonStat = new Button("Statistique");


        buttonProduct.addActionListener(evt -> {
            new BoProductsPage().show();
        });
        buttonStat.addActionListener(evt -> {
            new BoPostsPage().show();
        });
        buttonCommande.addActionListener(evt -> {
            new BoCommandeForm().show();
        });
        addAll(buttonProduct,buttonCommande,buttonStat);
    }
    
//-- DON'T EDIT BELOW THIS LINE!!!


// <editor-fold defaultstate="collapsed" desc="Generated Code">                          
    private void initGuiBuilderComponents(com.codename1.ui.util.Resources resourceObjectInstance) {
        setLayout(new com.codename1.ui.layouts.FlowLayout());
        setTitle("BackOfficeWindow");
        setName("BackOfficeWindow");
    }// </editor-fold>

//-- DON'T EDIT ABOVE THIS LINE!!!
}
