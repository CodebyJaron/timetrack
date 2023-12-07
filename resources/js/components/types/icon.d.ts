import {IconName, IconPathData, IconPrefix} from '@fortawesome/fontawesome-svg-core';
import {IconName as ProIconName} from '@fortawesome/pro-solid-svg-icons';

type IconDefinition = {
    icon: [number, number, string[], string, IconPathData];
    prefix: IconPrefix;
    // IconNames are incompatible
    iconName: IconName | ProIconName;
};
