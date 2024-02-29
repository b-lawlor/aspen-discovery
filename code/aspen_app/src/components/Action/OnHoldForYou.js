import { Button, ButtonText } from '@gluestack-ui/themed';
import React from 'react';
import { ThemeContext } from '../../context/initialContext';

// custom components and helper files
import { navigate, navigateStack } from '../../helpers/RootNavigator';

export const OnHoldForYou = (props) => {
     const { theme } = React.useContext(ThemeContext);
     const handleNavigation = () => {
          if (props.prevRoute === 'DiscoveryScreen' || props.prevRoute === 'SearchResults' || props.prevRoute === 'HomeScreen') {
               navigateStack('AccountScreenTab', 'MyHolds', {});
          } else {
               navigate('MyHolds', {});
          }
     };

     return (
          <Button size="md" bgColor={theme['colors']['primary']['500']} variant="solid" onPress={handleNavigation}>
               <ButtonText textAlign="center" p="$0">
                    {props.title}
               </ButtonText>
          </Button>
     );
};