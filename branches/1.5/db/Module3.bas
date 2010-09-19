Attribute VB_Name = "Module1"
Option Explicit

Public responsibles As Scripting.Dictionary
Public Const export_file As String = "c:\upload\export123.sql"


Sub DeleteFile(file As String)
    Dim fso

    Set fso = CreateObject("Scripting.FileSystemObject")
    If fso.FileExists(file) Then
        fso.DeleteFile file, True
    Else
        Debug.Print file & " does not exist or has already been deleted!" _
                , vbExclamation, "File not Found"
    End If
End Sub


' This routine returns the number of dimensions of the array
' passed as an argument, or 0 if it isn't an array.
Function NumberOfDims(arr As Variant) As Integer
    Dim dummy As Long
    On Error Resume Next
    Do
        dummy = UBound(arr, NumberOfDims + 1)
        If Err Then Exit Do
            NumberOfDims = NumberOfDims + 1
    Loop
End Function

' this routine will go through strategies on active sheet
' and generates insert for each row
Sub ExportSheetStrategy()
Attribute ExportSheetStrategy.VB_ProcData.VB_Invoke_Func = " \n14"
    ' jump into field with strategy or exit
    If Not findValueAndSetPosition("Strategy") Then Exit Sub
    ' go one cell down
    ActiveCell.Offset(1, 0).Range("A1:B2").Select
    Dim rng As Range
    Dim counter As Long
    counter = 0
            
    While counter < 3
        Dim s As String
        s = getRangeValue(Selection.value)
    
        If s <> vbNullString Then
            export_print "Insert into bsc_strategy (name, csf_name, lc, term) values( '" & s & "', '" & ActiveSheet.Name & "', 3, 6);"
            counter = 0
        Else
            counter = counter + 1
        End If
        ' go one cell down
        ActiveCell.Offset(1, 0).Select
    Wend
    
End Sub

Sub initResponsible()
    Set responsibles = Nothing
    Set responsibles = New Dictionary

End Sub

' this routine will go through strategies on active sheet
' and generates insert for each row
Sub ExportSheetResponsible()
    ' reset sheet position
    Range("A1").Select
    ' jump into field with strategy or exit
    If Not findValueAndSetPosition("Responsible") Then Exit Sub
    ' go one cell down
    ActiveCell.Offset(1, 0).Range("A1:B2").Select
    Dim rng As Range
    Dim counter As Long
    Dim max_counter As Long
    max_counter = 20
    counter = 0
    While counter < max_counter
        Dim s As String
        s = getRangeValue(Selection.value)
        If s <> vbNullString Then
            If Not responsibles.Exists(s) Then
                export_print "Insert into bsc_responsible (name, lc, term) values( '" & s & "', 3, 6);"
                responsibles.Add s, s
            End If
            counter = 0
        Else
            counter = counter + 1
        End If
        ' go one cell down
        ActiveCell.Offset(1, 0).Select
    Wend
End Sub


Sub ExportSheetStrategyAction()

    If Not findValueAndSetPosition("Strategic Action") Then Exit Sub
    ActiveCell.Offset(1, 0).Select
    Dim rng As Range
    Dim counter As Long
    Dim prev_s As String
    prev_s = "initialized"
    counter = 0
            
    While counter < 20
        Dim s As String, sa As String, sql As String
        sa = getRangeValue(Selection.Value2)
        s = getRangeValue(Selection.Offset(0, -1).value)
        If s = vbNullString Then
            s = getRangeValue(Selection.Offset(0, -1).MergeArea.value)
        End If
        If s = vbNullString Then
            s = prev_s
        End If
    
        If sa <> vbNullString Then
            sql = "select id from bsc_strategy where name = '" & s & _
                "' and csf_name = '" & ActiveSheet.Name & "' limit 0,1"
            export_print "Insert into bsc_action (name, strategy, lc, term)" & _
                                     " values( '" & sa & "', (" & sql & "), 3, 6);"
            counter = 0
        Else
            counter = counter + 1
        End If
        ActiveCell.Offset(1, 0).Select
        prev_s = s
    Wend
    
End Sub

Sub ExportSheetOperationAction()

    Dim s As String, sa As String, sql As String, sql2 As String, prev_s As String
    Dim rng As Range
    Dim counter As Long
    Dim new_action As String, prev_action As String
    Dim new_respo As String, prev_respo As String
    Dim new_operation As String, prev_operation As String
    prev_operation = "initialized"
    prev_action = "initialized"
    prev_respo = "initalized"
    prev_s = "initalized"

    If Not findValueAndSetPosition("Operational Actions") Then Exit Sub
    ActiveCell.Offset(1, 0).Select
    
    counter = 0
    While counter < 20
        sa = getRangeValue(Selection.Value2)
        ' read action
        s = getRangeValue(Selection.Offset(0, -1).value)
        If s = vbNullString Then
            s = getRangeValue(Selection.Offset(0, -1).MergeArea.value)
            Debug.Print "action is empty, using " & s
        End If
        If s = vbNullString Then
            s = prev_s
            Debug.Print "action is empty, using " & s
        End If
    
        If sa <> vbNullString Then
            sql = "select id from bsc_action where name = '" & s & "' limit 0,1"
            ' read responsible
            new_respo = getRangeValue(Selection.Offset(0, 1).value)
            If new_respo = vbNullString Then
                Debug.Print "new_respo is empty using " & prev_respo; ""
                new_respo = prev_respo
            End If
            sql2 = "select id from bsc_responsible where name = '" & _
                new_respo & "' limit 0,1"
            prev_respo = new_respo
            
            ' read operation
            new_operation = getRangeValue(Selection.Offset(0, 2).Next.value)
            If new_operation = vbNullString Then
                new_operation = prev_operation
            End If
            
            export_print "Insert into bsc_operation (name, action, when_txt, responsible, lc, term)" & _
                        " values( '" & sa & _
                        "', (" & sql & _
                        "), '" & new_operation & _
                        "', (" & sql2 & "), 3, 6);"
            prev_operation = new_operation
            counter = 0
            
        Else
            counter = counter + 1
        End If
        ActiveCell.Offset(1, 0).Select
        prev_s = s
    Wend
    
End Sub

Function findValueAndSetPosition(ByVal looking As String) As Boolean

    Dim find As Variant
    ActiveSheet.Range("A1").Select
    export_print "-- Looking for " & looking
    Set find = Cells.find(What:=looking, After:=ActiveCell, LookIn:=xlFormulas, _
        LookAt:=xlPart, SearchOrder:=xlByRows, SearchDirection:=xlNext, _
        MatchCase:=False, SearchFormat:=False)
        
    findValueAndSetPosition = False
    If IsNull(find) Or (find Is Nothing) Then Exit Function
    export_print "-- Found in " & ActiveSheet.Name & " " & find.Address
    find.Activate
    
    findValueAndSetPosition = True

End Function

Function getRangeValue(value As Variant) As String
    Dim s As String
    Select Case NumberOfDims(value)
    Case 0
        s = CStr(value)
    Case 1
        s = CStr(value(1))
    Case 2
        s = CStr(value(1, 1))
    End Select
    getRangeValue = s
End Function

Sub ExportAllSheetsStrategy()
    
    Dim Count As Long
    Count = Sheets.Count
    
    DeleteFile export_file
    Open export_file For Output As #1
    Print #1, "start transaction;"
    Close #1
    
    initResponsible
    Dim k As Long
        Dim l As Long
    For k = 1 To 4
        Select Case k
        Case 1
           Debug.Print "exporting responsibles"
        Case 2
            Debug.Print "exporting strategies"
        Case 3
           Debug.Print "exporting actions"
           ' ExportSheetStrategyAction
        Case 4
           Debug.Print "exporting operations"
           ' ExportSheetOperationAction
        End Select
        For l = 3 To Count
            Sheets(l).Activate
            Select Case k
            Case 1
               ExportSheetResponsible
            Case 2
               ExportSheetStrategy
            Case 3
               ExportSheetStrategyAction
            Case 4
               ExportSheetOperationAction
            End Select
        Next l
    Next k
    
    export_print "commit;"
    
End Sub

Sub export_print(s As String)

    Open export_file For Append As #1
    Print #1, s
    Close #1

End Sub

