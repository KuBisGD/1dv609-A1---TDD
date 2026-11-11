## Testing tools

 - **xUnit**: PHPUnit (has coverage with Xdebug on)
 - **Mocking**: Mockery (has PHPUnit integrations)
 - **Coverage**: PHPUnit?

## Notes

### console part:
 - menu class (Menu)
    - takes menu options
 - option class (MenuOption)
    - takes description text
    - takes option select value
    - takes Closure for action
        - if closure returns a value is should be sent up the chain and return form the menu/runner?
        - or closure return value is printed via output interface
 - Menu runner class (MenuRunner)
    - takes a menu output formatting interface (for styling)
    - takes the menu itself
    - takes I/O interfaces
 - MenuFormatter class
    - method for rendering menu
    - method for invalid option selection
 - Input interface
 - Output interface

#### extras

 - **MenuSession**:	Manages repeated interactions, such as continuing until the user quits	Repeats after an invalid choice; stops on quit
 - sub-menus (can be done with current?)

### Quiz

 - uses the menu
 - Quiz class
    - takes a QuestionDeck
    - could save scores etc.
 - QuestionDeck
    - takes questions (as object or from file?)
    - contains questions in some manner
    - would have nextQuestion: Question and hasNextQuestion: bool methods etc.
 - Question class
    - takes a question
    - takes options 
        - as array<string, bool>
        - as array<int, array{answer: string, isCorrect: bool}> (better for json?)
        - answer(int $selection): bool method?